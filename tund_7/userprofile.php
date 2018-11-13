<?php
require("functions.php");
//kui ei ole sisse loginud kontroll
if(!isset($_SESSION["userId"])){
	header("Location: index_2.php");
	exit();
}
//väljalogimine
if (isset($_GET["logout"])){
	session_destroy();
	header("Location: index_2.php");
	exit();
}

$mydescription = "Pole tutvustust lisanud!";
$mybgcolor = "#FFFFFF";
$mytxtcolor = "#000000";

if(isset($_POST["submitProfile"])){
	$notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $mydescription = $_POST["description"];
	}
	$mybgcolor = $_POST["bgcolor"];
	$mytxtcolor = $_POST["txtcolor"];
  } else {
	$myprofile = showmyprofile();
	if($myprofile->description != ""){
	  $mydescription = $myprofile->description;
    }
    if($myprofile->bgcolor != ""){
	  $mybgcolor = $myprofile->bgcolor;
    }
    if($myprofile->txtcolor != ""){
	  $mytxtcolor = $myprofile->txtcolor;
    }
  }
?>


<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
	<style>
	  <?php
        echo "body{background-color: " .$mybgcolor ."; \n";
		echo "color: " .$mytxtcolor ."} \n";
	  ?>
	</style>
  <body>
	<h2>Kirjuta natukene endast:</h2>
	<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
	<br>
	<label>Taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>">
	<label>Tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	<input name="submitBtn" type="submit" value="Salvesta profiil"><br>
	<hr>
	<ul>
	<li><a href="?logout=1">Logi välja</a></li>
	<li><a href="main.php">Tagasi pealehele</a></li>
	</ul>
</body>
</html>