<?php
	session_start();
	
	$manager = $_SESSION["username"];
	$playerID = $_REQUEST["php_var"];
	
	// Datenbank verbinden
	include_once("MySQL_Conn.php");
	
	$result=mysql_query("UPDATE `tblSpielerliste` SET `Manager` = 0, `Time` = NULL WHERE  `idPlayer` = ".$playerID);
	
	include_once("pick.php");

?>
