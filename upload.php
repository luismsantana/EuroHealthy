<?php

/*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

    header ("Location: user/login.html");

}*/

session_start();


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 *
 */
/*$file = $_FILES['file'];

$file_name = $file['name'];
$file_tmp = $file['tmp_name'];

$file_ext = explode('.', $file_name);
$file_ext = end($file_ext);

$file_name_new = uniqid('', 1) .  '.' . $file_ext;
$file_dest = "uploads/" . $file_name_new;

if(move_uploaded_file($file_tmp, $file_dest)){
    echo "File has been uploaded!!! <br>";
}else{
    echo "File has not been uploaded!!! <br>";
}*/

$accept = 1;
$accept1 = 1;

function verifica_nutsCode($s){

    //echo "coluna 1 ";

    $nuts_code = file("nuts_code.txt", FILE_IGNORE_NEW_LINES);

    if(in_array($s, $nuts_code)){
        return 1;
    }
}

function retorna_numero_titulo_indicador_2($indicador, $indicadores){
    if(in_array($indicador[0], $indicadores) and $indicador[1] === "2000"){
            return 1;
        }

        return 0;
}

function retorna_numero_titulo_indicador_3($format, $indicador, $indicadores){
    if(in_array($format, $indicadores) and $indicador[2] === "2000"){
            return 1;
        }

        return 0;
}

function verifica_indicadores($string){


    $indicadores = file("indicadores.txt", FILE_IGNORE_NEW_LINES);

    $indicador = explode("_", $string);

    if(sizeof($indicador) === 2){
        return retorna_numero_titulo_indicador_2($indicador, $indicadores);

    }

    if(sizeof($indicador) === 3){
        $format = $indicador[0] . '_' . $indicador[1];

        return retorna_numero_titulo_indicador_3($format, $indicador, $indicadores);

    }

    return 0;
}

function getFloat($str) {
  if(strstr($str, ",")) {
    $str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
    $str = str_replace(",", ".", $str); // replace ',' with '.'
  }

  return $str;
  /*if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
    return floatval($match[0]);
  } else {
    return floatval($str); // take some last chances with floatval
  } */
}

function verifica_indicadores_valor($string){
    //echo "valor: ";
    if(is_numeric(getFloat($string))){
        return 1;
    }
    return 0;

}

function verifica_3_celulas($array){

    //echo "3 primeiras celulas do ficheiro ";

    if($array[0][0] === "NUTS_CODE" or $array[0][1] === "NUTS_LABEL" or $array[0][2] === "COUNTRY_CODE"){
        return 1;
    }

    return 0;

}

function verifica_linha($linha, $array){

    $accept = 1;

    if(!verifica_3_celulas($array)){
        return 0;
    }

    for($j=0; $j<count($array[$linha]); $j++){

        if($j === 0 and $linha>0){
            $accept = verifica_nutsCode($array[$linha][$j]);

        }

        if($j>2 and $linha===0){
            $accept = verifica_indicadores($array[$linha][$j]);

        }

        if($j>2 and $linha>0){
            $accept = verifica_indicadores_valor($array[$linha][$j]);

        }

        if($accept === 0){
            return 0;
        }
    }



    return 1;

}

function check_csv($file){

    $rows = array();

    $i = 0;

    foreach( file($file, FILE_IGNORE_NEW_LINES) as $line){


		    $rows[] = str_getcsv($line, ";");
		        //for($j=0; $j<82;$i++){
		            //switch($i){
		                //case 0:if($rows[0][0] === "NUTS_CODE" and $rows[0][1] === "NUTS_LABEL" and $rows[0][2] === "COUNTRY_CODE" and $i === 0){
		    //if($i === 0){
		        //echo "tres corretas ";

		       // verifica_linha(0, $rows);

		    //}

		    //if($i > 0){


		    $accept = verifica_linha($i, $rows);
		    //}
		    //
		    //
		    //
		    //echo "\n";
		                    //break;
		            //}
		        //}

		    if($accept === 0){
		        return 0;
		    }

		    $i++;


		}

        return 1;
    }

function check_shape($file){
	$zip = zip_open($file);
	if($zip){
		while ($zip_entry = zip_read($zip)){
			$name = zip_entry_name($zip_entry);
			$ext =  explode('.', $name);
			$ext = end($ext);

			$array= array('shp', 'shx', 'dbf', 'prj', 'sbn', 'sbx', 'fbn', 'fbx', 'ain', 'aih', 'ixs', 'mxs', 'atx', 'xml', 'cpg', 'qix');
			if(!in_array($ext, $array)){
				return 0;
			}

    /*  if($ext!=='shp' or $ext!=='shx' or $ext!=='dbf' or $ext!=='prj' or $ext!=='sbn' or $ext!=='sbx' or $ext!=='fbn' or $ext!=='fbx' or $ext!=='ain' or $ext!=='aih' or $ext!=='ixs' or $ext!=='mxs' or $ext!=='atx' or $ext!=='xml' or $ext!=='cpg' or $ext!=='qix'){
          return 0;
		  }*/

		zip_close($zip);
	}

	return 1;
  }
  return 0;
}

    //print_r($rows);
    //return $rows;
/*function report($string){
    $ano = $_POST['ano'];
    $dir = "uploads/" . $_SESSION['regiao'] . '/' . $ano[0] . 'report.csv';

    $file = fopen($dir, 'w');
    $rows = array();
    foreach( file($string, FILE_IGNORE_NEW_LINES) as $line ){
        $rows[] = str_getcsv($line, ";");


    }

        echo "\n";

    print_r($rows);
    echo "\n";
}*/

if(isset($_POST['ano'])){

  if($_FILES["file"]['name'] !== "" and $_FILES["file1"]['name'] !== "" and $_FILES["fileShape"]['name'] !== "" and $_FILES["fileTxt"]['name'] !== ""){

      $ano = $_POST['ano'];

      $dir = array();
      $dir1 = array();
      $dir2 = array();
      $dir3 = array();

      for($i=0; $i<sizeof($ano); $i++){
          $dirAno = $ano[$i];
          $dir[$i] = "uploads/" . $_SESSION['regiao'] . "/". $ano[$i] . "/" . $_FILES["file"]["name"];
      }

      for($i=0; $i<sizeof($ano); $i++){
          $dirAno = $ano[$i];
          $dir1[$i] = "uploads/" . $_SESSION['regiao'] . "/". $ano[$i] . "/" . $_FILES["file1"]["name"];
      }

      for($i=0; $i<sizeof($ano); $i++){
          $dirAno = $ano[$i];
          $dir2[$i] = "uploads/" . $_SESSION['regiao'] . "/". $ano[$i] . "/" . $_FILES["fileShape"]["name"];
      }

      for($i=0; $i<sizeof($ano); $i++){
          $dirAno = $ano[$i];
          $dir3[$i] = "uploads/" . $_SESSION['regiao'] . "/". $ano[$i] . "/" . $_FILES["fileTxt"]["name"];
      }

      $_SESSION['ano[]'] = $ano;

      $tmp = $_FILES["file"]["tmp_name"];
      $ext = explode('.', $_FILES["file"]['name']);
      $ext = end($ext);

      $tmp_alpha_txt = $_FILES['file1']['tmp_name'];
      $ext_alpha_txt = explode('.', $_FILES['file1']['name']);
      $ext_alpha_txt = end($ext_alpha_txt);

      $tmp_geo_shape = $_FILES['fileShape']['tmp_name'];
      $ext_geo_shape = explode('.', $_FILES['fileShape']['name']);
      $ext_geo_shape = end($ext_geo_shape);

      $tmp_geo_txt = $_FILES['fileTxt']['tmp_name'];
      $ext_geo_txt = explode('.', $_FILES['fileTxt']['name']);
      $ext_geo_txt = end($ext_geo_txt);

      if($ext === "csv" and $ext_alpha_txt === "txt" and $ext_geo_shape === "zip" and $ext_geo_txt === "txt"){

          $accept = check_csv($_FILES["file"]["name"]);
          $accept1 = check_shape($_FILES["fileShape"]["name"]);

          if($accept === 1 and $accept1 === 1){
              if(move_uploaded_file($tmp, $dir[0]) and move_uploaded_file($tmp_alpha_txt, $dir1[0]) and
                      move_uploaded_file($tmp_geo_shape, $dir2[0]) and move_uploaded_file($tmp_geo_txt, $dir3[0])){
                  //report($dir[0]);
                  echo "Uploaded!!!!<br>";

                  echo "vai copiar agora: \n";
                  $file_to_copy = $dir[0];
                  $file_to_copy_1 = $dir1[0];
                  $file_to_copy_2 = $dir2[0];
                  $file_to_copy_3 = $dir3[0];

                  for($i=1; $i<sizeof($_SESSION['ano[]']); $i++){
                      echo $i . "= ";
                      if(copy($file_to_copy, $dir[$i]) and copy($file_to_copy_1, $dir1[$i]) and
                              copy($file_to_copy_2, $dir2[$i]) and copy($file_to_copy_3, $dir3[$i])){
                          echo "Copied!!!!<br>";
                      }else{
                          echo " Not Copied!!!!<br>";
                      }

                      echo "\n";
                  }

                  $_SESSION['upload'] = 1;
                  $_SESSION['falha'] = 0;
                  $_SESSION['razaofalha'] = "";

                  header("Location: report.php");



              }else{
                  echo " Not Uploaded!!!!<br>";
                  $_SESSION['upload'] = 0;
                  $_SESSION['falha'] = 1;
                  $_SESSION['razaofalha'] = "There was a problem with the server. Please try again later.";
                  header("Location: index.php");
              }



          }else{
              $_SESSION['falha'] = 1;
              $_SESSION['razaofalha'] = "The file has an incorrect data.";
              $_SESSION['upload'] = 0;
              header("Location: index.php");
          }
      }else{
          $_SESSION['falha'] = 1;
          $_SESSION['razaofalha'] = "The file has an incorrect extension.";
          $_SESSION['upload'] = 0;
          header("Location: index.php");
      }
  }else{
      $_SESSION['falha'] = 1;
      $_SESSION['razaofalha'] = "All files must be submited.";
      $_SESSION['upload'] = 0;
      header("Location: index.php");

  }
}else{
  $_SESSION['falha'] = 1;
  $_SESSION['razaofalha'] = "An year must be selected.";
  $_SESSION['upload'] = 0;
  header('Location: index.php');
}




?>
