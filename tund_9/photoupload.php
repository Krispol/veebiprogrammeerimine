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
				
				//loome vastavalt failitüübile pildiobjekti
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "png"){
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "gif"){
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				//arvutan suuruse suhtarvu
				if($imageWidth > $imageHeight){
					$sizeRatio = $imageWidth / 600;
				} else {
					$sizeRatio = $imageHeight / 400;
				}
				
				$newWidth = round($imageWidth / $sizeRatio);
				$newHeight = round($imageHeight / $sizeRatio);
				
				$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
				
				//lisan vesimärgi
				$waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
				$waterMarkWidth = imagesx($waterMark);
				$waterMarkHeight = imagesy($waterMark);
				$waterMarkPosX = $newWidth - $waterMarkWidth - 10;
				$waterMarkPosY = $newHeight - $waterMarkHeight - 10;
				
				imagecopy($myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
				
				//lisame ka teksti
				$textToImage = "Veebiprogrammerimine";
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 60);
				imagettftext($myImage, 20, 0, 10, 30, $textColor, "../vp_picfiles/ARIALBD.TTF", $textToImage);
				
				
				//lähtudes failitüübist, kirjutan pildifaili
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
					if(imagejpeg($myImage, $target_file, 95)){
						echo "Fail " . basename( $_FILES["fileToUpload"]["name"]). " on edukalt üles laetud!";
					    addPhotoData($target_file_name, $_POST["alttext"], $_POST["privacy"]);
					} else {
						echo "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
					}
				}
				if($imageFileType == "png"){
					if(imagepng($myImage, $target_file, 6)){
						echo "Fail " . basename( $_FILES["fileToUpload"]["name"]). " on edukalt üles laetud!";
						addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
					} else {
						echo "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
					}
				}
				if($imageFileType == "gif"){
					if(imagegif($myImage, $target_file)){
						echo "Fail " . basename( $_FILES["fileToUpload"]["name"]). " on edukalt üles laetud!";
						addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
					} else {
						echo "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
					}
				}
				
				imagedestroy($myTempImage);
				imagedestroy($myImage);
				
				
/* 				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "Fail " . basename( $_FILES["fileToUpload"]["name"]). " on edukalt üles laetud!";
				} else {
					echo "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
				} */
			}
			
		}
	}//kontroll, kas vajutati nuppu
	
	function resizeImage($image, $ow, $oh, $w, $h){
		$newImage = imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
		return $newImage;
	}
  
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
		<li><a href="?logout=1">Logi välja!</a></li>
	</form>
  </body>
</html>