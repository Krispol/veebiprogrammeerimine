<?php
  require("functions.php");
  
  if(!isset($_SESSION["userId"])) {
	  header("location: index_2.php");
	  exit();
  }
  //välja logimine
  if(isset($_GET["logout"])) {
	  session_destroy();
	  header("location: index_2.php");
	  exit();
  }
  
  $msglist = readallvalidatedmessagesbyuser();
  
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Valideeritud anonüümsed sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja!</a></li>
	<li><a href="main.php">Tagasi pealehele!</a></li>
  </ul>
  <hr>
  <h2>Valideeritud sõnumid valideerijate kaupa</h2>
  <p>Valideeritud sõnumid:</p>
  <?php echo readallvalidatedmessages();?>

</body>
</html>
