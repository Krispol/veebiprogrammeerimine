<?php
  require("functions.php");
  //kui pole sisse loginud
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
  $pageTitle = "Pealeht";
  require("header.php");
  
?>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Olete sisse loginud nimega: 
	<?php
		echo $_SESSION["firstName"] ." " .$_SESSION["lastName"];
	?>
	</p>
	<ul>
		<li><a href="?logout=1">Logi välja!</a></li>
		<li><a href="addmsg.php">Lisa sõnum!</a></li>
		<li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
		<li><a href="validatedmessages.php">Vaata valideeritud sõnumeid</a></li>
		<li><a href="userprofile.php">Redigeeri enda profiilisätteid</a></li>
		<li>Piltide <a href="photoupload.php">üleslaadimine</a></li>
	</ul>
  </body>
</html>