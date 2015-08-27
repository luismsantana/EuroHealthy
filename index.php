<?php
session_start();



/*if (!(isset($_SESSION['login']) && $_SESSION['login'] == 0)) {

    header ("Location: user/login.php");

}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
print_r($_SESSION);

?>

<html>
    <head>
        <style type="text/css"></style>
        <link href="estilos.css" rel="stylesheet" type="text/css">


    </head>
    <body>

	<div class="fundologin" style="position:absolute;bottom:0px;top:0px;left:0px;right:0px">
		<a href="user/logout.php">Logout</a>

		<div class="whitecontainer">
			<form enctype="multipart/form-data" action="upload.php" method="post">

			    <select class="selectano" name='ano[]' multiple="multiple" size="4" >
				<?php
				for($i=2001; $i<2015; $i++){
				    echo "<option value='$i'> $i</option>";
				}
				?>
			    </select>
				<a href="#" onclick="return false;" style="cursor:default;text-decoration:none;color:green;"><img style="width:15px; height:15px;" src="images/questionmark.png"></a>
				<div class="hidden">
					<p>To select more than one year:</p>
					<p class="paragrafos">i) For consecutive years, drag the mouse from the first to the last.</p>
					<p class="paragrafos">ii) Otherwise, hold control key and click in the desired years.</p>

				</div>
			    <br><?php
                                            if($_SESSION['falha'] === 1 and $_SESSION['upload'] === 0 and $_SESSION['razaofalha'] !== ""){
                                                ?>
                            <div class="uploadnegado">
                                <?php
                                    echo $_SESSION['razaofalha'];
                                ?>
                            </div>
                                <?php
                                        $_SESSION['falha'] = -1;
                                        $_SESSION['razaofalha'] = "";
                                            }
                                        ?>

                                        <?php
                                            if($_SESSION['falha'] === 0 and $_SESSION['upload'] === 1 and $_SESSION['razaofalha'] === ""){
                                                ?>
                            <div class="uploadaceite">
                                <?php
                                    echo "The files have been uploaded.";
                                ?>
                            </div>
                                <?php
                                        $_SESSION['falha'] = -1;
                                        $_SESSION['razaofalha'] = "";
                                            }
                                        ?>
				<div>
					<h3 style="text-align:center">ALPHANUMERIC</h3><br>
					CSV FILE:
					<input style="margin-left:49px" name="file" type="file" id="file" class="inputs"><br>

					TXT FILE:
					<input name="file1" type="file" id="file1" class="inputs">
				</div>
		<br>
			    <br>
		    	<h3 style="text-align:center">METADATA</h3><br>
				<div>
						SHAPE FILES:

						<input style="margin-left:13px" name="fileShape" type="file" id="fileShape">
				<br>
						TXT FILE:

						<input name="fileTxt" type="file" id="fileTxt" class="inputs">

				</div><br>
			    <br>
			    <input type="submit" id="button" value="Upload Files" name="button">

			</form>
		</div>
	</div>

<p>ewfkhbsfisdfh</p>
    </body>
</html>
