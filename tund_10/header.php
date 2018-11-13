<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta charset="utf-8">
		<meta name="description" content="Nendel lehtedel leidub igast koolitööga seotud asju">
		<meta name="author" content="Kristjan Põldmets">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>VP <?php echo $pageTitle; ?></title>
		<style>
		<link rel="stylesheet" href="http://greeny.cs.tlu.ee/~krispol/veebiprogrammeerimine/style.css">
		<?php
			echo "body{background-color: " .$mybgcolor ."; \n";
			echo "color: " .$mytxtcolor ."} \n";
		?>
		</style>
	</head>
	<body>
	<div>
		<a href="main.php">
		<img src="../vp_picfiles/vp_logo_w135_h90.png" alt="vp logo">
		<img src="../vp_picfiles/vp_banner.png" alt="vp bänner">
		</a><br>
		<div><a href="main.php">Pealeht</a>
		<a href="addmsg.php">Sõnumi lisamine</a>
		<a href="validatemsg.php">Valideeri sõnumeid</a>
		<a href="validatedmessages.php">Vaata sõnumeid</a>
		<a href="userprofile.php">Profiilisätted</a>
		<a href="photoupload.php">Piltide üleslaadimine</a>
		</div>
	</div>
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<p>See leht on valminud <a href="https://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ning ei sisalda eriliselt väärtuslikku materjali</p>
	<hr>
