<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const FILE_PATH = __DIR__ . '/../../Assets/Artikel.csv';

    public function readCSV(){
        if(!file_exists(self::FILE_PATH)) {
            return response(["error" => "Server error"], 500, ["Content-type" => "application/json"]);
        }

        $fileResource = fopen(self::FILE_PATH, 'r');
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
            /* if($rowCounter === 50) {
                break;
            } */
        }
        fclose($fileResource);

        return response()->json($tableArray);
    }

    public function appendCSV(Request $request){
        if(!file_exists(self::FILE_PATH)) {
            return response(["error" => "Server error"], 500, ["Content-type" => "application/json"]);
        }

        $collection = $request->collect();

        $newRow = $collection->map(fn($value) => htmlspecialchars($value));

        if($newRow->filter(function($value, $key){
            if(preg_match('/Ärmel|Bein|Kragen|Herstellung|Taschenart|Grammatur|Ursprungsland|Bildname/',$key)){
                return false;
            }
            return true;
        })->contains(fn($value) => $value === "")){
            return response()->json(["error"=>"Incorrect input", "data" => $newRow]);
        }

        $fileResource = fopen(self::FILE_PATH, 'a');

        fputcsv($fileResource, [...$newRow->values()], ';');

        fclose($fileResource);

        return response()->json(["ok"=>"correct input", "data" => $newRow]);
    }

    public function exportCSV() {
        if(!file_exists(self::FILE_PATH)) {
            return response(["error" => "Server error"], 500, ["Content-type" => "application/json"]);
        }
        return response()->download(self::FILE_PATH, "Artikel.csv", ["Content-type"=>"text/csv"]);
    }
}
