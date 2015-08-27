<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function floatvar($str) {
  if(strstr($str, ",")) {
    $str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
    $str = str_replace(",", ".", $str); // replace ',' with '.'
  }

  if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
    return floatval($match[0]);
  } else {
    return floatval($str); // take some last chances with floatval
  }
}

$to_csv = array();


    $anos = $_SESSION['ano[]'];
    $dir_report = "uploads/lisboa/" . $anos[0] . '/report_' . $anos[0] . '.csv';
    $dir_file_para_report = "uploads/" . $_SESSION['regiao'] . '/' . $anos[0] . '/Table.csv';
    $file = fopen($dir_report, 'w');

    $file_nome_indicadores = file('indicadores1linha.txt', FILE_IGNORE_NEW_LINES);

    $colunas = array();
    $medias = array();
    $minimos = array();

    $rows1 = array();

    foreach( file($dir_file_para_report, FILE_IGNORE_NEW_LINES) as $line){

        $rows1[] = str_getcsv($line, ";");
    }


    $rows = file($dir_file_para_report, FILE_IGNORE_NEW_LINES);

    for($i=0; $i<80; $i++){
        $medias[$i] = 0;
    }
    $media = 0;
    $k = 0;

    for($i=1; $i<304;$i++){
        $k=0;
        for($j=3 ; $j<83; $j++){

            $medias[$k++] += floatvar($rows1[$i][$j]);

        }

    }

    for($i=0; $i< count($medias); $i++){
        $medias[$i] /= 303;
    }

    $mediasString = array();
    for($i=0; $i< count($medias); $i++){
        $mediasString[$i] = strval($medias[$i]);
    }

    //calcular minimos

    $k=0;
        for($j=3 ; $j<83; $j++){

            $minimos[$k++] = floatvar($rows1[1][$j]);

        }

        for($i=1; $i<304;$i++){
            $k=0;
            for($j=3 ; $j<83; $j++){
                if(floatvar($rows1[$i][$j]) < $minimos[$k]){
                    $minimos[$k] = floatvar($rows1[$i][$j]);
                }
                $k++;
            }

        }

        //calcular maximos
        $k=0;
        for($j=3 ; $j<83; $j++){

            $maximos[$k++] = floatvar($rows1[1][$j]);
        }

        for($i=1; $i<304;$i++){
            $k=0;
            for($j=3 ; $j<83; $j++){
                //$num = floatval();
                if(floatvar($rows1[$i][$j]) > $maximos[$k]){
                    $maximos[$k] = floatvar($rows1[$i][$j]);
                }
                $k++;
            }

        }

        $k=0;

        for($j=1; $j<81; $j++){

                //$to_csv[0] = $file_nome_indicadores;
                $to_csv[1][0] = "Mean";
                $to_csv[2][0] = "Lower Value";
                $to_csv[3][0] = "Greater Value";
                $to_csv[4][0] = "Number of Lines";
                $to_csv[1][$j] = $mediasString[$k];
                $to_csv[2][$j] = $minimos[$k];
                $to_csv[3][$j] = $maximos[$k];

                $k++;
            }

            foreach($file_nome_indicadores as $fields){
                fputcsv($file, explode(";", $fields), ";", '"');
            }


        foreach($to_csv as $fields){
            fputcsv($file, $fields, ";", '"');
        }


        for($i=0; $i<sizeof($anos); $i++){
            $dir[$i] = 'uploads/' . $_SESSION['regiao'] . '/' . $anos[$i] . '/report_' . $anos[$i] . '.csv';
        }

        $file_to_copy = "uploads/" . $_SESSION['regiao'] . '/' . $anos[0] . '/report_' . $anos[0] . '.csv';

        for($i=1; $i<sizeof($anos); $i++){

            if(copy($file_to_copy, $dir[$i])){
                echo "Copied!!!!<br>";
            }else{
                echo " Not Copied!!!!<br>";
            }

        }



        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    		header('Content-Description: File Transfer');
    		header("Content-type: text/csv");
    		header("Content-Disposition: attachment; filename={$file_to_copy}");
    		header("Expires: 0");
    		header("Pragma: public");

    		readfile($file_to_copy);

        //fclose($file);


        //header("Location: index.php");
