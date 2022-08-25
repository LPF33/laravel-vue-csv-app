<?php

namespace App\Utilities;

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
