<?php
	session_start();
	
	$user = $_SESSION["username"];

	
	// Datenbank verbinden
	include_once("MySQL_Conn.php");
	
	// Alle noch verfügbaren Spieler aus DB auslesen
	$res=mysql_query("SELECT `Name`, `Position`, `Nachname` , `Verein` , `Marktwert` FROM `tblSpielerliste`, `tblManager` WHERE `Manager` = `idManager` ORDER BY TIME DESC LIMIT 0,5")or die(mysql_error ());	

	$result=mysql_query("SELECT `this` FROM `Pick`")or die(mysql_error());
	$next = mysql_fetch_array($result);
	$manager = $next[0];
	echo '<p><b>'.$manager.' ist an der Reihe</b></p>';
	while($row=mysql_fetch_row($res)){

		echo '<p><b>'.$row[0].' wählte '.$row[1].' '.$row[2].' '.$row[3].' für '.$row[4].' Mio.</b></p>';

	}

?>
