<?php
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
	//püüan "POST" andmed kinni
	var_dump($_POST);
	if (isset($_POST["firstname"])){
		$firstName = $_POST["firstname"];
	}
	if (isset($_POST["lastname"])){
		$lastName = $_POST["lastname"];
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Siin lehel leidub igast asju">
	<meta name="author" content="Kristjan Põldmets">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" type="text/css" href="../../cascadingstylesheets.css"> -->
	<title>
	<?php
		echo $firstName;
		echo " ";
		echo $lastName;
	?>
	Yarr, there be kittens!</title>
</head>
<body>
	<h1>
	<?php
		echo $firstName ." " .$lastName;
	?>
	</h1>
	<p>See leht on valmistatud <a href="https://www.tlu.ee/">TLÜ</a> <a href="https://www.tlu.ee/dt">Digitehnoloogiate instituudi</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu</p>
	<p>See tekst siin on lisatud koduarvutis</p>
	<hr>
	
	<form method="POST">
		<label>Eesnimi: </label>
		<input type="text" name="firstname">
		<label>Perenimi: </label>
		<input type="text" name="lastname">
		<label>Sünniaasta: </label>
		<input type="number" min="1915" max="2000" value="1993" name="birthyear">
		<input type="submit" name="submitUserData" value="Saada andmed">
	</form>
	<hr>
	<?php
		if (isset($_POST["birthyear"])){
			echo "<p>Olete elanud järgnevatel aastatel:</p> \n";
			echo "<ul> \n";
				for ($i = $_POST["birthyear"]; $i <= date("Y"); $i++){
					echo "<li>" .$i ."</li> \n";
				}
			echo "</ul> \n";
		}
	?>
	
</body>
</html>