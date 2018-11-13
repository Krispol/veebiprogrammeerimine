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
  $msglist = readallunvalidatedmessages();
  $pageTitle = "Valideeri sõnumeid";
  require("header.php");
?>
  <p>Valideerimata sõnumid:</p>
  <?php echo $msglist; ?>
  <hr>
  <li><a href="?logout=1">Logi välja!</a></li>
</body>
</html>
