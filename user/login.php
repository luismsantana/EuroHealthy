<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



header('Content-Type: text/plain');

session_start();

//$_SESSION['login'] = 0;

//if($_SESSION['login'] === 0){
    if(isset($_POST['username']) and isset($_POST['password'])){

        $file = file("information.txt", FILE_IGNORE_NEW_LINES);

        foreach ($file as $line){
            $information = explode(" ", $line);
        }

        $user = $information[0];
        $pass = $information[1];

    ////$user = "luismsantana";
    $pass = "13423139";

    $uname = strip_tags($_POST["username"]);

    $ppass = strip_tags($_POST["password"]);

        if($uname == $user and $ppass == $pass){
            $_SESSION['login'] = 1;
            $_SESSION['username'] = $user;
            $_SESSION['regiao'] = $information[2];
            $_SESSION['falha'] = 0;
            $_SESSION['razaofalha'] = "";
            $_SESSION['upload'] = 0;

            Header("Location: /EuroHealthy/welcome.html");
            echo "login sucessfull!!\n";
        //else{
           // echo "incorrect login!!\n";
        }
}
echo "\n\n";
print_r($_POST);
print_r($_SESSION);

?>
