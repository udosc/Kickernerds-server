<?php 
session_start(); 

include_once("MySQL_Conn.php");

$username = $_POST["username"]; 

$ergebnis = mysql_query( "SELECT COUNT(*) FROM tblManager WHERE Name LIKE '".$username."'" ) or die(mysql_error ()); 

$row =  mysql_fetch_row($ergebnis);

if($row[0] > 0) 
    { 
		$_SESSION["username"] = $username; 
		$check = mysql_query("SELECT user FROM online WHERE user = '".$username."'")or die(mysql_error());

		$r = mysql_fetch_row($check);
		if(!$r[0]){
			echo "Hallo ". $_SESSION["username"].", hier geht es weiter: <br> <a href=\"pick.php\">Gesch�tzer Bereich</a>"; 
			$ergebnis = mysql_query( "INSERT INTO chat (absender, nachricht, time) VALUES ('System', '".$username." ist Online', CURRENT_TIMESTAMP)" ) or die(mysql_error ()); 
			$res = mysql_query("INSERT INTO online (user, time) VALUES ('".$username."', CURRENT_TIMESTAMP)") or die(mysql_error());
		}
		else{
			echo "Willkommen zur�ck ". $_SESSION["username"].", bitte melde dich das n�chste Mal �ber den logout Button ab. <br> <a href=\"pick.php\">Gesch�tzer Bereich</a>"; 
		}
    } 
else 
    { 
    echo "Benutzername ist falsch. <a href=\"login.php\">Login</a>"; 
    } 

?>
