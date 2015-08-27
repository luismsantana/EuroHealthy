<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

    header ("Location: user/login.html");

}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<html>
    <head>

    </head>
    <body>
        <form enctype="multipart/form-data" action="upload.php" method="post">
            <select>
                <?php
                for($i=2001; $i<2015; $i++){
                    echo "<option value='$i'> $i</option>";
                }
                ?>
            </select>
            <br>
            <h3>ALPHANUMERIC</h3>
            CSV FILE:
            <input name="file" type="file" id="file"><br>
            TXT FILE:
            <input name="file1" type="file" id="file1"><br>
            <br>
            <h3>METADATA</h3>
            SHAPE FILES:
            <input name="fileShape" type="file" id="fileShape"><br>
            TXT FILE:
            <input name="fileTxt" type="file" id="fileTxt"><br>
            <br>
            <input type="submit" id="button" value="Upload Files" name="button">
        </form>
        <br><br><br><br><br>
        <a href="user/logout.php">Logout</a>
    </body>
</html>
