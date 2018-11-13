<?php
	//lisan teise php faili
	require("functions.php");
	$notice = "";
	$firstName = "";
	$lastName = "";
	$birthMonth = null;
	$birthDay= null;
	$birthDay = null;
	$birthDate = "";
	$gender = null;
	$email = "";
	//püüan "POST" andmed kinni
	//var_dump($_POST);
	if (isset($_POST["firstname"])){
		$firstName = test_input($_POST["firstname"]);
	}
	if (isset($_POST["lastname"])){
		$lastName = test_input($_POST["lastname"]);
	}
    $month = intval(date('m'));
	$months = [
		'et' => [
			1 => 'Jaanuar',
			2 => 'Veebruar',
			3 => 'Märts',
			4 => 'Aprill',
			5 => 'Mai',
			6 => 'Juuni',
			7 => 'Juuli',
			8 => 'August',
			9 => 'September',
			10 => 'Oktoober',
			11 => 'November',
			12 => 'Detsember',
		]
	];
	
	function stupidfunction() {
		$GLOBALS["fullName"] = $GLOBALS["firstName"] ." " .$GLOBALS["lastName"];
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Siin lehel leidub igast asju">
	<meta name="author" content="Kristjan Põldmets">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" type="text/css" href="../../cascadingstylesheets.css"> 
	
			<label>Sünnikuu: </label>
			echo '<select name="birthMonth">' ."\n;
			if ($i == $birthMonth) {
				echo " selected";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n*;
		)
	-->
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
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Eesnimi: </label>
		<input type="text" name="firstname">
        <br>
		<label>Perenimi: </label>
		<input type="text" name="lastname">
        <br>
		<label>Sünniaasta: </label>
		<input type="number" min="1915" max="2000" value="1993" name="birthyear">
        <br>
        <select name="birthMonth">
			<?php foreach($months['et'] as $key => $m): ?>
				<option <?= $month == $key ? 'selected':'' ?> value="<?= $key ?>"><?= $m ?></option>
			<?php endforeach; ?>
		</select>
		<input type="submit" name="submitUserData" value="Saada andmed">
	</form>
	<hr>
	<?php
		if (isset($_POST["birthyear"])){
			echo "<p>" .$fullName ."</p>";
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