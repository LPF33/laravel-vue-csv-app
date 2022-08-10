<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const FILE_PATH = __DIR__ . '/../../Assets/Artikel.csv';

    public function readCSV(){
        $fileResource = fopen(self::FILE_PATH, 'r');
        if($fileResource === false) {
            exit(print_r("Cannot read {self::FILE_PATH} file"));
        }

        $tableArray = [
            'header' => [],
            'body' => [],
        ];
        $rowCounter = 0;
        while (!feof($fileResource) && ($rowCSV = fgetcsv($fileResource,0,";")) !== false) {
            if($rowCounter === 0) {
                $tableHeader = [];
                foreach($rowCSV as $key) {
                    $tableHeader[] = $key;
                }
                $tableArray['header'] = $tableHeader;
            }else {
                $newRow = [];
                for($i=0; $i < count($rowCSV); $i++) {
                    $newRow[$tableArray['header'][$i]] = trim($rowCSV[$i]);
                }
                array_push($tableArray['body'], $newRow);
            }
            $rowCounter++;
            if($rowCounter === 50) {
                break;
            }
        }
        fclose($fileResource);

        header('Content-Type: application/json');
        echo json_encode($tableArray);
    }
}
