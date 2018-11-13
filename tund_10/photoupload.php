<?php
  require("functions.php");
  
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	header("Location: index_2.php");
    exit();	
  }
  
  //välja logimine
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index_2.php");
    exit();
  }
  
  require("classes/Photoupload.class.php");
 /*  require("classes/Test.class.php");
   $myNumber = new Test(666);
  echo "Avalik arv on: " .$myNumber->publicNumber;
  //echo "Salajane arv on: " .$myNumber->secretNumber;
  $myNumber->tellThings();
  $myNumber = new Test(9);
  echo "Teine avalik arv on: " .$mySNumber->publicNumber;
  unset($myNumber); */
  
  
  
  
  //piltide üleslaadimise osa
	$target_dir = "../vp_pic_uploads/";
	
	$uploadOk = 1;
	
	// Check if image file is a actual image or fake image
	if(isset($_POST["submitImage"])) {
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			
			$timeStamp = microtime(1) * 10000;
			
			$target_file_name = "vp_" .$timeStamp ."." .$imageFileType;
			
			$target_file = $target_dir .$target_file_name;
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "Fail on " . $check["mime"] . " pilt.";
				//$uploadOk = 1;
			} else {
				echo "Fail ei ole pilt!";
				$uploadOk = 0;
			}
			
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Vabandage, selline pilt on juba olemas!";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 2500000) {
				echo "Vabandust, pilt on liiga suur!";
				$uploadOk = 0;
			}
			
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Vabandage, ainult JPG, JPEG, PNG ja GIF failid on lubatud!";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Kahjuks faili üles ei laeta!";
			// if everything is ok, try to upload file
			} else {
				
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto->changePhotoSize(600, 400);
				$myPhoto->addWaterMark();
				$myPhoto->addText();
				$savesuccess = $myPhoto->saveFile($target_file);
				unset($myPhoto);
				
				if($savesuccess = 1){
					addPhotoData($target_file_name, $_POST["alttext"], $_POST["privacy"]);
					} else {
						echo "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
					}
				}
				
				/* 				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "Fail " . basename( $_FILES["fileToUpload"]["name"]). " on edukalt üles laetud!";
				} else {
					echo "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
				} */
			}
			
		
	}//kontroll, kas vajutati nuppu
	
	
  
  //lehe päise laadimine
  $pageTitle = "Piltide üleslaadimine";
  require("header.php");
?>
	<form action="photoupload.php" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label>Vali üleslaetav pilt:</label><br>
		<input type="file" name="fileToUpload" id="fileToUpload"><br>
		<label>Pildi alternatiivne kirjeldus(max 256 tähemärki): </label>
		<input type="text" name="alttext">
		<br>
		<label>Pildi kasutusõigused</label><br>
		<input type="radio" name="privacy" value="1"><label>Avalik</label>
		<input type="radio" name="privacy" value="2"><label>Sisseloginud kasutajale</label>
		<input type="radio" name="privacy" value="3" checked><label>Privaatne</label>
		<input type="submit" value="Lae üles" name="submitImage">
		<hr>
		<div><a href="?logout=1">Logi välja!</a></div>
	</form>
  </body>
</html>