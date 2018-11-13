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
  $pageTitle = "Valideeritud sõnumid valideerijate kaupa";
  require("header.php");
?>
  <?php echo $msglist; ?>
  <hr>
  <li><a href="?logout=1">Logi välja</a></li>
</body>
</html>
