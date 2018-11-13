<?php
	require("functions.php");
	$notice = null;
	if(isset($_POST["submitMessage"])){
		if ($_POST["message"] != "Kirjuta oma sõnum siia..." and !empty($_POST["message"])){
			$message = test_input($_POST["message"]);
			$notice = saveamsg($message);
		} else {
			$notice = "Palun kirjuta sõnum!";
		}
	}
	$pageTitle = "Sõnumi lisamine";
	require("header.php");
?>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);
	?>">
		<label>Sõnum (max 256 märki): </label>
		<br>
		<textarea name="message" rows="4" cols="64">Kirjuta oma sõnum siia ...</textarea>
		<br>
		<input type="submit" name="submitMessage" value="Salvesta sõnum">
	</form>
	<p><?= $notice; ?></p>
	<br>
	<li><a href="?logout=1">Logi välja!</a></li>
</body>
</html>