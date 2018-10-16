<?php
	require("functions.php");
	
	$notice = null;
	
	if(isset($_POST["submitMessage"])){
		if ($_POST["message"] != "Kirjuta oma sõnum siia..." and !empty($_POST["message"])){
			$message = test_input ($_POST["message"]);
			$notice = saveamsg($message);
		} else {
			$notice = "Palun kirjuta sõnum!";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Siin lehel leidub igast koolitööga seotud asju">
	<meta name="author" content="Kristjan Põldmets">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Anonüümse sõnumi lisamine</title>
</head>
<body>
	<h1>Sõnumi lisamine</h1>
	<p>See leht on valmistatud <a href="https://www.tlu.ee/">TLÜ</a> <a href="https://www.tlu.ee/dt">Digitehnoloogiate instituudi</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);
	?>">
		<label>Sõnum (max 256 märki): </label>
		<br>
		<textarea name="message" rows="4" cols="64">Kirjuta sõnum siia ...</textarea>
		<br>
		
		<input type="submit" name="submitMessage" value="Salvesta sõnum">
	</form>
	<hr>
	<p><?= $notice; ?></p>

</body>
</html>