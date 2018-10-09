<?php
	$firstName = "Kristjan";
	$lastName = "Põldmets";
	
	//loeme kataloogi lahti
	$dirToRead = "../../pics/";
	$allFiles = scandir($dirToRead);
	//var_dump($allFiles);
	$picFiles = array_slice($allFiles, 2);
	
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
	
	<?php
		for ($i  = 0; $i < count ($picFiles); $i++){
			echo '<img src="' .$dirToRead .$picFiles[$i] .'" alt="Pilt">';
		}
	?>
	
</body>
</html>