<?php
	//echo "See on minu esimene php!";
	$firstName = "Kristjan";
	$lastName = "Põldmets";
	$dateToday = date("d.m.Y");
	$hourNow = date("G");
	$partOfDay = "";
	if ($hourNow < 8) {
		$partOfDay = "varajane hommik";
	}
	if ($hourNow > 8 and $hourNow <16) {
		$partOfDay = "koolipäev";
	}
	if ($hourNow >16) {
		$partOfDay = "loodetavasti vaba aeg";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Siin lehel leidub igast asju">
	<meta name="author" content="Kristjan Põldmets">
	<meta name="veiwport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="cascadingstylesheets.css">
	<title>Yarr, there be kittens!</title>
	<?php
		echo $firstName;
		echo " ";
		echo $lastName;
	?>
</head>
<body>
	<h1>
	<?php
		echo $firstName ." " .$lastName;
	?>
	</h1>
	<h2>Yarr, there be kittens!</h2>
	<img src="kitten.jfif" alt="Yarrkitty" title="a kitten">
	<?php
		echo "<p>Tänane kuupäev on: " .$dateToday .".</p> \n";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .", käes oli " .$partOfDay .".</p> \n";
	?>
	<img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="TLÜ" title="TLÜ">
	<p>See leht on valmistatud <a href="https://www.tlu.ee/">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu</p>
	<p>See tekst siin on lisatud koduarvutis</p>
	<p>Minu sõps teeb ka <a href="../../~laurrau/" target="blank">veebi</a></p>
</body>
</html>