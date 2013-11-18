<?php
	session_start();
	
	$manager = $_SESSION["username"];
	$playerID = $_REQUEST["php_var"];

	include_once("MySQL_Conn.php");
	//Position des Spielers aulesen
	$result=mysql_query("SELECT `Position` from `tblSpielerliste` WHERE `idPlayer` = ".$playerID)
or die(mysql_error());
	if ( $row = mysql_fetch_row($result) ){
		$position = $row [0];
	}

	$tor = $_SESSION["tor"];
	$abw = $_SESSION["abw"];
	$mit = $_SESSION["mit"];
	$stu = $_SESSION["stu"];

	if ( $position == "TOR" ){
		$tor++;
	} else	if ( $position == "ABW" ){
		$abw++;
	} else	if ( $position == "MIT" ){
		$mit++;
	} else	if ( $position == "STU" ){
		$stu++;
	}

	$verein_sql=mysql_query("SELECT COUNT(*) from `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."') AND `Verein` = ( SELECT `Verein` FROM `tblSpielerliste` WHERE `idPlayer` = '".$playerID."')") or die(mysql_error());
	if ( $row_v = mysql_fetch_row($verein_sql) ){
		$verein = $row_v [0];
	}

	$resultName =mysql_query("SELECT `This` from `Pick` WHERE `id` = 2 ")
or die(mysql_error());
	if ( $row_name = mysql_fetch_row($resultName) ){
		$pick = $row_name [0];
	}

	if( $pick == $manager or $pick == "X" or 1 == 1){
		if ( $tor <= 3 and $abw <= 6 and $mit <= 8 and $stu <= 5 and $verein < 4 ) {

			$count_player=mysql_query("SELECT COUNT(*) from `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error());
			if ( $row_count = mysql_fetch_row($count_player) ){
				$counter = $row_count [0];
			}

			if( $counter >= 22 ) {
				$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'X', `last` = 'X' WHERE  `id` = 2") or die(mysql_error());
			} else {
			
				$resultLast =mysql_query("SELECT `Last` FROM `Pick` WHERE `id` = 2 ")
					or die(mysql_error());
				if ( $row_last = mysql_fetch_row($resultLast) ){
					$last = $row_last [0];
				}
				if( $pick == "Udo" ){
					if( $last == "Udo" ){
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Marvin', `last` = 'Udo' WHERE  `id` = 2") or die(mysql_error());
					} else {
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Udo', `last` = 'Udo' WHERE  `id` = 2") or die(mysql_error());
					}
				} else if( $pick == "Johannes" ){
					if( $last == "Johannes" ){
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Christoph', `last` = 'Johannes' WHERE  `id` = 2") or die(mysql_error());
					} else {
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Johannes', `last` = 'Johannes' WHERE  `id` = 2") or die(mysql_error());
					}
				} else if( $pick == "Christoph" ){
					if( $last == "Johannes" ){
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Benjamin', `last` = 'Christoph' WHERE  `id` = 2") or die(mysql_error());
					} else {
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Johannes', `last` = 'Christoph' WHERE  `id` = 2") or die(mysql_error());
					}
				} else if( $pick == "Benjamin" ){
					if( $last == "Christoph" ){
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Marvin', `last` = 'Benjamin' WHERE  `id` = 2") or die(mysql_error());
					} else {
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Christoph', `last` = 'Benjamin' WHERE  `id` = 2") or die(mysql_error());
					}
				} else if( $pick == "Marvin" ){
					if( $last == "Benjamin" ){
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Udo', `last` = 'Marvin' WHERE  `id` = 2") or die(mysql_error());
					} else {
						$result_upadte=mysql_query("UPDATE `Pick` SET `this` = 'Benjamin', `last` = 'Marvin' WHERE  `id` = 2") or die(mysql_error());
					}
				}
			}

	

	
			$result_upadte=mysql_query("UPDATE `tblSpielerliste` SET `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."'), `Time` = CURRENT_TIMESTAMP WHERE  `idPlayer` = ".$playerID)or die(mysql_error());
	
			$_SESSION["invalid_pick"] = FALSE;
		} else {
			$_SESSION["invalid_pick"] = TRUE;
		}
 	} else {
		$_SESSION["turn"] = TRUE;
	}
		
	include_once("pick.php")

?>
