<?php
  require("functions.php");
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	  header("Location: index_2.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
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
  //lehe päise laadimine
  $pageTitle = "Kasutaja: " .$_SESSION["firstName"] ." " .$_SESSION["lastName"];
  require("header.php");
?>
	<form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Kirjuta natukene endast:</label><br>
		<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
		<br>
		<label>Taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>">
		<label>Tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
		<input name="submitProfile" type="submit" value="Salvesta profiil"><br>
	</form>
	<hr>
	<li><a href="?logout=1">Logi välja</a></li>
</body>
</html>