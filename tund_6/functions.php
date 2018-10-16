<?php
	require("../../../config.php");
	$database = "if18_kristjan_po_1";
	//echo $serverHost;
	
	//kasutan sessiooni
	session_start();
	
	//SQL käskandmete uuendamiseks
	//UPDATE vpamsg SET acceptedby=?, accepttime=now() WHERE id=?
	
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