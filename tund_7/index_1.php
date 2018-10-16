<?php
	//echo "See on minu esimene php!";
	//massiiv on muutuja, millel on mitu erinevat väärtust - kandilised sulud []
	$firstName = "Kristjan";
	$lastName = "Põldmets";
	$dateToday = date("d.m.Y");
	$weekdayToday = date("N");
	$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//var_dump ($weekdayNamesET); - Järjestus algab 0-ga
	echo $weekdayNamesET[1];
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
	//$picURL = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	$picURL = "../../pics/";
	$picEXT = ".jpg";
	$picNUM = mt_rand(2,43);
	echo $picNUM;
	$picFILE = $picURL .$picNUM .$picEXT;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Siin lehel leidub igast asju">
	<meta name="author" content="Kristjan Põldmets">
	<meta name="veiwport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../../cascadingstylesheets.css">
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
	<p>Teised lehed: <a href="photo.php">photo.php</a></p><a href="page.php">page.php</a></p>
	<img src="../../kitten.jfif" alt="Yarrkitty" title="a kitten">
	<?php
		echo "<p>Täna on " .$weekdayNamesET[$weekdayToday -1] .", " .$dateToday .".</p> \n";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .", käes oli " .$partOfDay .".</p> \n";
	?>
	<img src="<?php echo $picFILE; ?>" alt="TLÜ" title="TLÜ">
	<p>See leht on valmistatud <a href="https://www.tlu.ee/">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu</p>
	<p>See tekst siin on lisatud koduarvutis</p>
	<p>Minu sõps teeb ka <a href="../../../~laurrau/tund3/" target="blank">veebi</a></p>
</body>
</html>