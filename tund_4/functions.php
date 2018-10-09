<?php
	require("../../../config.php");
	$database = "if18_kristjan_po_1";
	//echo $serverHost;
    function add_cat($name, $color, $length) {
        $notice = null;
        $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
        $sql = $conn->prepare('INSERT INTO cat(cat_name, cat_color, tail_length) VALUES(?, ?, ?)');
        echo $conn->error;
        $sql->bind_param('ssi', $name, $color, $length);
        if($sql->execute()) {
            $notice = 'Data saved!';
        }
        else {
            $notice = 'Data saving failed! Error: '.$sql->error;
        }
        $sql->close();
        $conn->close();
        return $notice;
    }

    function read_cats() {
        $notice = null;
        $conn = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
        $sql = $conn->prepare('SELECT cat_name, cat_color, tail_length FROM cat');
        echo $conn->error;
        $sql->bind_result($name, $color, $length);
        if($sql->execute()) {
            while ($sql->fetch()) {
                $notice .= '<li>'.$name.', '.$color.', '.$length.'</li>';
            }
        } else {
            $notice = 'Data loading failed! Error: '.$sql->error;
        }
        $sql->close();
        $conn->close();
        return $notice;
    }

	function saveamsg ($msg) {
		$notice = "";
		//loome andmebaasiühenduse
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistan ette andmebaasikäsi
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
		echo $mysqli->error;
		//asendan ettevalmistatud käsus küsimärgid päris andmetega
		//esimesena kirja andmetüübid, siis andmed ise
		//s- string i- integer d- decimal
		$stmt->bind_param("s", $msg);
		//täidame ettevalmistatud käsu
		if ($stmt->execute())
			$notice = 'sõnum: "' .$msg .'" on edukalt salvestatud!';
		else {
			$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
		}
		//sulgeme ettevalmistatud käsu
		$stmt->close();
		//sulgeme ühenduse
		$mysqli->close();
		return $notice;
	}

	function readallmessages() {
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		$stmt->bind_result($msg);
		$stmt->execute();
		while($stmt->fetch()){
			$notice .= "<p>".$msg ."</p> \n";
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