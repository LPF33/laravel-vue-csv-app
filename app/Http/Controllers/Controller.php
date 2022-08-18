<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Delimiter
{
    public static $delimiter = ',';

    public static $delimiters = [
        ',' => 0,
        ';' => 0,
        "\t" => 0,
        '|' => 0,
    ];

    public static function getDelimiter(string $filePath): string
    {
        $fileResource = fopen($filePath, 'r');
        $firstLine = fgets($fileResource);
        fclose($fileResource);

        foreach (self::$delimiters as $delimiter => &$counter) {
            $counter = count(str_getcsv($firstLine, $delimiter));
        }

        return array_search(max(self::$delimiters), self::$delimiters);
    }
}

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const FOLDER_PATH = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Assets';

    const FILE_PATH = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Upload.csv';

    const NEW_FILE_PATH = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'NewUpload.csv';

    const FILE_NAME = 'Upload.csv';

    /**
     * Only read the CSV file
     *
     * Test, if file exists. If not, send a error message with JSON.
     * If exists, open file. Create associative array, to store seperated CSV table header and body.
     * Iterate over file, read every line. Store first line in $tableArray["header"].
     * Other lines store as Array in body, with the depending key from header.
     * Send response as json.
     */
    public function readCSV(Request $request)
    {
        if (! file_exists(self::FILE_PATH)) {
            return response(['error' => 'Upload CSV file'], 200, ['Content-type' => 'application/json']);
        }

        $fileResource = fopen(self::FILE_PATH, 'r');

        $tableArray = [
            'header' => [],
            'body' => [],
        ];
        $rowCounter = 0;

        $delimiter = $request->session()->get('delimiter', function () {
            return Delimiter::getDelimiter(self::FILE_PATH);
        });

        while (! feof($fileResource) && ($rowCSV = fgetcsv($fileResource, 0, $delimiter)) !== false) {
            if ($rowCounter === 0) {
                $tableHeader = [];
                foreach ($rowCSV as $key) {
                    $tableHeader[] = $key;
                }
                $tableArray['header'] = $tableHeader;
            } else {
                $newRow = [];
                for ($i = 0; $i < count($rowCSV); $i++) {
                    $newRow[$tableArray['header'][$i]] = trim($rowCSV[$i]);
                }
                array_push($tableArray['body'], $newRow);
            }
            $rowCounter++;
        }
        fclose($fileResource);

        return response()->json($tableArray);
    }

    /**
     * Read old file, write new file with new data. Delete old file. Rename new file.
     *
     * Read the Request. Validate index and data send with request.
     * Open old (flag r) and new file (flag w). Read old file, write line to new file, when index reached, write data to new file.
     * When old file is deleted and new file renamed, send response for success.
     */
    public function writeCSV(Request $request)
    {
        $collection = $request->collect();

        $rowIndex = filter_var($collection['index'], FILTER_VALIDATE_INT);

        $newRow = collect($collection['data'])->map(fn ($value) => trim(strip_tags($value)));

        if ($newRow->filter(function ($value, $key) {
            if (preg_match('/Ärmel|Bein|Kragen|Herstellung|Taschenart|Grammatur|Ursprungsland|Bildname/', $key)) {
                return false;
            }

            return true;
        })->contains(fn ($value) => $value === '') || $rowIndex === false) {
            return response()->json(['error' => 'Incorrect input']);
        }

        $fileResource = fopen(self::FILE_PATH, 'r');
        $newFileResource = fopen(self::NEW_FILE_PATH, 'w');

        if ($fileResource === false || $newFileResource === false) {
            return response(['error' => 'Server error'], 500, ['Content-type' => 'application/json']);
        }

        $delimiter = $request->session()->get('delimiter', function () {
            return Delimiter::getDelimiter(self::FILE_PATH);
        });

        $rowCounter = 0;
        while (! feof($fileResource) && ($rowCSV = fgetcsv($fileResource, 0, $delimiter)) !== false) {
            if ($rowCounter === $rowIndex + 1) {
                fputcsv($newFileResource, [...$newRow->values()], $delimiter);
            } else {
                fputcsv($newFileResource, $rowCSV, $delimiter);
            }
            $rowCounter++;
        }
        fclose($newFileResource);
        fclose($fileResource);

        if (! unlink(self::FILE_PATH) || ! rename(self::NEW_FILE_PATH, self::FILE_PATH)) {
            return response(['error' => 'Server error'], 500, ['Content-type' => 'application/json']);
        }

        return response()->json(['ok' => 'correct input']);
    }

    /**
     * Append a new row to CSV file.
     *
     * Validate data send with Request. Open file with flag a. Put data to end of file.
     * When successful send response.
     */
    public function appendCSV(Request $request)
    {
        $collection = $request->collect();

        $newRow = collect($collection['data'])->map(fn ($value) => trim(strip_tags($value)));

        if ($newRow->filter(function ($value, $key) {
            if (preg_match('/Ärmel|Bein|Kragen|Herstellung|Taschenart|Grammatur|Ursprungsland|Bildname/', $key)) {
                return false;
            }

            return true;
        })->contains(fn ($value) => $value === '')) {
            return response()->json(['error' => 'Incorrect input', 'data' => $newRow]);
        }

        $fileResource = fopen(self::FILE_PATH, 'a');

        if ($fileResource === false) {
            return response(['error' => 'Server error'], 500, ['Content-type' => 'application/json']);
        }

        $delimiter = $request->session()->get('delimiter', function () {
            return Delimiter::getDelimiter(self::FILE_PATH);
        });

        fputcsv($fileResource, [...$newRow->values()], $delimiter);

        fclose($fileResource);

        return response()->json(['ok' => 'correct input', 'data' => $newRow]);
    }

    /**
     * Export CSV file and trigger download in browser.
     *
     * If file exists, use download function in response.
     */
    public function exportCSV()
    {
        if (! file_exists(self::FILE_PATH)) {
            return redirect('/');
        }

        return response()->download(self::FILE_PATH, self::FILE_NAME, ['Content-type' => 'text/csv']);
    }

    /**
     * Import CSV file
     *
     * Check if file is present in request and has been uploaded with HTTP and no error occurred.
     * Check for MIME type (not safe value). Delete old Artikel.csv and move uploaded file to Assets-folder.
     */
    public function importCSV(Request $request)
    {
        try {
            if (! $request->hasFile('file') || ! $request->file('file')->isValid()) {
                return response('Bad request', 400);
            }

            $file = $request->file('file');

            if ($file->getClientMimeType() !== 'text/csv') {
                return response()->json(['error' => 'Incorrect file type']);
            }

            if (file_exists(self::FILE_PATH) && ! unlink(self::FILE_PATH)) {
                return response('Server error', 500);
            }

            $file->move(self::FOLDER_PATH, self::FILE_NAME);

            $request->session()->put('delimiter', Delimiter::getDelimiter(self::FILE_PATH));

            return response()->json(['ok' => 'correct input']);
        } catch (FileException $err) {
            return response('Server error', 500);
        }
    }
}
