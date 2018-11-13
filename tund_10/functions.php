<?php
	require("../../../config.php");
	$database = "if18_kristjan_po_1";
	//echo $serverHost;
	
	//kasutan sessiooni
	session_start();
	
	function addPhotoData($filename, $alttext, $privacy){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES(?, ?, ?, ?)");
	echo $mysqli->error;
	if(empty($privacy) or $privacy > 3 or $privacy < 1){
		$privacy = 3;
	}
	$stmt->bind_param("issi", $_SESSION["userId"], $filename, $alttext, $privacy);
	if($stmt->execute()){
		echo "Andmebaasiga on kõik korras!";
	} else {
		echo "Andmebaasiga läks midagi viltu!" .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
  }
	
  function readprofilecolors(){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT bgcolor, txtcolor FROM userprofiles WHERE userid=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($bgcolor, $txtcolor);
	$stmt->execute();
	$profile = new Stdclass();
	if($stmt->fetch()){
		$_SESSION["bgColor"] = $bgcolor;
		$_SESSION["txtColor"] = $txtcolor;
	} else {
		$_SESSION["bgColor"] = "#FFFFFF";
		$_SESSION["txtColor"] = "#000000";
	}
	$stmt->close();
	$mysqli->close();
  }
  
  //kasutajaprofiili salvestamine
  function storeuserprofile($desc, $bgcol, $txtcol){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM userprofiles WHERE userid=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($description, $bgcolor, $txtcolor);
	$stmt->execute();
	if($stmt->fetch()){
		//profiil juba olemas, uuendame
		$stmt->close();
		$stmt = $mysqli->prepare("UPDATE userprofiles SET description=?, bgcolor=?, txtcolor=? WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("sssi", $desc, $bgcol, $txtcol, $_SESSION["userId"]);
		if($stmt->execute()){
			$notice = "Profiil edukalt uuendatud!";
			$_SESSION["bgcolor"] = $bgcol;
		    $_SESSION["txtcolor"] = $txtcol;
		} else {
			$notice = "Profiili uuendamisel tekkis tõrge! " .$stmt->error;
		}
	} else {
		//profiili pole, salvestame
		$stmt->close();
		//INSERT INTO vpausers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)"
		$stmt = $mysqli->prepare("INSERT INTO userprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("isss", $_SESSION["userId"], $desc, $bgcol, $txtcol);
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
			$_SESSION["bgcolor"] = $bgcol;
		    $_SESSION["txtcolor"] = $txtcol;
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
	
	//kasutajaprofiili väljastamine
	function showmyprofile(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM userprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($description, $bgcolor, $txtcolor);
		$stmt->execute();
		$profile = new Stdclass();
		if($stmt->fetch()){
			$profile->description = $description;
			$profile->bgcolor = $bgcolor;
			$profile->txtcolor = $txtcolor;
		} else {
			$profile->description = "";
			$profile->bgcolor = "";
			$profile->txtcolor = "";
		}
		$stmt->close();
		$mysqli->close();
		return $profile;
	  }
	
	//kõigi valideeritud sõnumite lugemine valideerija/kasutaja kaupa
	function readallvalidatedmessagesbyuser(){
		$msghtml ="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpausers");
		echo $mysqli->error;
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
		
		$stmt2=$mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
		$stmt2->bind_param("i", $idFromDb);
		$stmt2->bind_result($msgFromDb, $acceptedFromDb);
		
		$stmt->execute();
		//et saadud tulemus püsiks ja oleks kasutatav ka järgmises päringus $stmt2
		$stmt->store_result();
		
	while($stmt->fetch()){
	  $msghtml .= "<h3>" . $firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
	  $stmt2->execute();
	  while($stmt2->fetch()){
		$msghtml .= "<p><b>";
		if($acceptedFromDb == 1){
		  $msghtml .= "Lubatud: ";
		} else {
		  $msghtml .= "Keelatud: ";
		}
		$msghtml .= "</b>" .$msgFromDb ."</p> \n";
	  }//while $stmt2 fetch
	}//while $stmt fetch
	$stmt2->close();
	$stmt->close();
	$mysqli->close();
	return $msghtml;
  }
  
  //kõigi valideeritud sõnumite lugemine valideerija kaupa
  function readallvalidatedmessagesbyuser_vana(){
	$msghtml ="";
	$result = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpausers");
	echo $mysqli->error;
	$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
	
	$stmt2 = $mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
	$stmt2->bind_param("i", $idFromDb);
	$stmt2->bind_result($msgFromDb, $acceptedFromDb);
	
	$stmt->execute();
	//et saadud tulemus püsiks ja oleks kasutatav ka järgmises päringus ($stmt2)
	$stmt->store_result();
	
	while($stmt->fetch()){
	  $msghtml .= "<h3>" . $firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
	  $resultcounter = 0;
	  $stmt2->execute();
	  while($stmt2->fetch()){
		$msghtml .= "<p><b>";
		if($acceptedFromDb == 1){
		  $msghtml .= "Lubatud: ";
		} else {
		  $msghtml .= "Keelatud: ";
		}
		$msghtml .= "</b>" .$msgFromDb ."</p> \n";
		$resultcounter ++;
	  }//while $stmt2 fetch
	  if($resultcounter > 0){
		  $result .= $msghtml;
		}
		
		$msghtml = "";
	}//while $stmt fetch
	$stmt->free_result();
	$stmt2->close();
	$stmt->close();
	$mysqli->close();
	return $msghtml;
  }
  
	
	//kasutajate nimekiri
	function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpausers WHERE id !=?");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $lastname, $email);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
	
	function validatemsg($editId, $validation){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?");
		$stmt->bind_param("iii", $_SESSION["userId"], $validation, $editId);
		if($stmt->execute()){
		echo "Õnnestus";
		header("Location: validatemsg.php");
		exit();
		} else {
		echo "Tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
  
	//valitud sõnumi lugemine valideerimiseks
	function readmsgforvalidation($editId){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($msg);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $msg;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function readallvalidatedmessages(){
		$notice = "<ul> \n"; //loendi algus
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NOT NULL");
		//SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC
		echo $mysqli->error;
		$stmt->bind_result($msgid, $msg);
		if($stmt->execute()){
			while($stmt->fetch()){
				$notice .= "<li>" .$msg .'</li>' ."\n";
			}
		} else {
			$notice .= "<li>Sõnumite lugemisel tekkis viga!" .$stmt->error ."</li> \n";
		}
		$notice .= "</ul> \n"; //loendi lõpp
		
		$stmt->close();
        $mysqli->close();
        return $notice;
	}
	
	//valideerimata sõnumite nimekiri
	function readallunvalidatedmessages(){
		$notice = "<ul> \n"; //loendi algus
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL");
		//SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC
		echo $mysqli->error;
		$stmt->bind_result($msgid, $msg);
		if($stmt->execute()){
			while($stmt->fetch()){
				$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$msgid .'">Valideeri</a></li>' ."\n";
			}
		} else {
			$notice .= "<li>Sõnumite lugemisel tekkis viga!" .$stmt->error ."</li> \n";
		}
		$notice .= "</ul> \n"; //loendi lõpp
		
		$stmt->close();
        $mysqli->close();
        return $notice;
	}
	
	//sisselogimine
	function signin($email, $password) {
		$notice = "";
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password from vpausers WHERE email=?");
		echo $mysqli->error;
		//bind_param on kasutusel kui tahad saata andmebaasi infot- hetkel saadame päringu
		$stmt->bind_param("s", $email);
		//Püüame vastuse andmebaasist, uuele muutujale passowrdFromDb kuna passoword on kasutusel
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
		if($stmt->execute()){
			//andmebaasi päring õnnestus, fetch käsuga tuleb saadud info anda muutujale passwordFromDb'le
			if($stmt->fetch()){
				//kasutaja on olemas, hakkame võrdlema andmebaasist saadud parooli sisestatud parooliga- Räsi
				if(password_verify($password, $passwordFromDb)){
					//parool õige
					$notice = "Olete sisse logitud!";
					
					
					
					//määrame sessiooni muutujad
					$_SESSION["userId"] =  $idFromDb;
					$_SESSION["firstName"] =  $firstnameFromDb;
					$_SESSION["lastName"] =  $lastnameFromDb;
					$stmt->close();
					$mysqli->close();
					header("Location: main.php");
					exit();
					//sulgesime ukse, ei jäta ust lahti
					
				} else {
					$notice = "Sisestatud salasõna on vale!";
				}
			} else {
				$notice = "Kahjuks sellise kasutajatunnusega (" .$email .") kasutajat ei leitud!";
			}	
	} else {
		$notice = "Sisselogimisel tekkis tehniline viga! Palun proovige järgmises elus uuesti." .$stmt->error;
	}
		$stmt->close();
        $mysqli->close();
        return $notice;
	}
	
	//registreerimine
    function signup($firstName, $lastName, $birthDate, $gender, $email, $password) {
        $notice = "";
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO vpausers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
        echo $mysqli->error;
        //krüpteerime parooli ära
        $options = ["cost"=>12, "salt"=>substr(sha1(mt_rand()), 0, 22)];
        $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
        $stmt->bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $pwdhash);
        if($stmt->execute()){
            $notice = "Kasutaja loomine õnnestus";
        } else {
            $notice = "Kasutaja loomisel tekkis viga: " .$stmt->error;
        }

        $stmt->close();
        $mysqli->close();
        return $notice;
	}
	
	function saveamsg($msg){
		$notice = "";
		//loome andmebaasiühenduse
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistan ette andmebaasikäsu
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
		echo $mysqli->error;
		//asendan ettevalmistatud käsus küsimärgi(d) päris andmetega
		// esimesena kirja andmetüübid, siis andmed ise
		//s - string; i - integer; d - decimal
		$stmt->bind_param("s", $msg);
		//täidame ettevalmistatud käsu
		if ($stmt->execute()){
		  $notice = 'Sõnum: "' .$msg .'" on edukalt salvestatud!';
		} else {
		  $notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
		}
		//sulgeme ettevalmistatud käsu
		$stmt->close();
		//sulgeme ühenduse
		$mysqli->close();
		return $notice;
	}
	
	function readallmessages(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		$stmt->bind_result($msg);
		$stmt->execute();
		while($stmt->fetch()){
			$notice .= "<p>" .$msg ."</p> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
  //teksti sisendi kontrollimine
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>