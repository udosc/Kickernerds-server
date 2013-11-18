<?php
	session_start();
	$user = $_SESSION["username"];

	// Datenbank verbinden
	include_once("MySQL_Conn.php");

	$res = mysql_query("INSERT INTO chat (absender, nachricht, time) 
					VALUES ('System', '".$user." ist Offline', '$zeit')")or die(mysql_error());
					
	$query = mysql_query("DELETE FROM `online` WHERE `user` = '".$user."'")or die(mysql_error());
	
	session_destroy();
	
	include("index.php");
?>