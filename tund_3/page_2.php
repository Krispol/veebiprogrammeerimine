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
    $month = intval(date('m'));


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
        <select name="birthMonth">
            <option <?= $month == 1 ? 'selected':'' ?> value="1">jaanuar</option>
            <option <?= $month == 2 ? 'selected':'' ?> value="2">veebruar</option>
            <option <?= $month == 3 ? 'selected':'' ?> value="3">mĆ¤rts</option>
            <option <?= $month == 4 ? 'selected':'' ?> value="4">aprill</option>
            <option <?= $month == 5 ? 'selected':'' ?> value="5">mai</option>
            <option <?= $month == 6 ? 'selected':'' ?> value="6">juuni</option>
            <option <?= $month == 7 ? 'selected':'' ?> value="7">juuli</option>
            <option <?= $month == 8 ? 'selected':'' ?> value="8">august</option>
            <option <?= $month == 9 ? 'selected':'' ?> value="9">september</option>
            <option <?= $month == 10 ? 'selected':'' ?> value="10">oktoober</option>
            <option <?= $month == 11 ? 'selected':'' ?> value="11">november</option>
            <option <?= $month == 12 ? 'selected':'' ?> value="12">detsember</option>
        </select><br><?php echo$month?>
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