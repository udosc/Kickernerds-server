<?php

session_start();
$user = $_SESSION["username"];

echo '
<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
	@import "style.css";
</style>
<script type="text/javascript" src="dragndrop.js"></script>
<script src="sorttable.js"></script>

<script type="text/javascript">
	function addPlayer(input){	
		var id = input.id;
		try{
			window.location.href = "addPlayer.php?php_var=" + escape(id); 
		}catch(e){
			alert("kein php");
		}
	}
	
	function delPlayer(input){
		var id = input.id;
		try{
			window.location.href = "delPlayer.php?php_var=" + escape(id); 
		}catch(e){
			alert("kein php");
		}
	}
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script>
		var auto_refresh = setInterval(
			function()
			{
				$("#last").fadeOut("slow").load("reload.php").fadeIn("slow");
			}, 30000);
		$(document).ready(function(){
				$("#last").load("reload.php")
			});
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script>
		var auto_refresh = setInterval(
			function()
			{
				$("#text").fadeOut("slow").load("reload.php").fadeIn("slow");
			}, 10000);
		$(document).ready(function(){
				$("#text").load("reload.php")
			});
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script>
		var auto_refresh = setInterval(
			function()
			{
				$("#list").fadeOut("slow").load("reload.php").fadeIn("slow");
			}, 30000);
		$(document).ready(function(){
				$("#list").load("reload.php")
			});
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script>
		var auto_refresh = setInterval(
			function()
			{
				$("#other").fadeOut("slow").load("reload.php").fadeIn("slow");
			}, 30000);
		$(document).ready(function(){
				$("#other").load("reload.php")
			});
</script>


<body>';
$invalid_pick = $_SESSION["invalid_pick"];
if( $invalid_pick ){
	echo '<script type="text/javascript"> alert("Ungültiger Pick")</script>';
	$_SESSION["invalid_pick"] = FALSE;
}


$invalid_turn = $_SESSION["turn"];
if( $invalid_turn ){
	echo '<script type="text/javascript"> alert("Du bist nicht an der Reihe")</script>';
	$_SESSION["turn"] = FALSE;
}

if(isset($_SESSION["username"]))
{
	$name = $_SESSION["username"];
	
	echo '<div class="topleft" ondrop="drop(event)" ondragover="allowDrop(event)">
	<img  src="logo.png" id="drag1" draggable="true" ondragstart="drag(event)"/>
	</div>
	<div class="topmiddle">';
	echo '<div class="lastpicks" id="last">';
		
		include_once("lastPicks.php");
		
	echo '
		</div>
		<div>
			<a href="http://kickernerdsdraft.zxq.net/pick.php" id="reload">reload</a>
			<a href="logout.php" id="logout">logout</a>
		</div>
	</div>';
	
	echo '<div class="chat">'; 
		echo '<div class="chattext" id="text">';
			include_once("ausgabe_chat_texte.php");
		echo '</div>';
		echo '<div>';
			include_once("form_chat_texte.php");
		echo '</div>';
    echo '</div>
		  <div class="announcements">
			<table>
			  <tr>
				<td><b>UPDATE:</b> </td>
				<td><marquee scrollamount=5 scrolldelay=5>&nbsp; --- <b>WINTERTRANSFER 16.01.2013 22:30 Uhr MESZ</b> --- | 
				--- Reihenfolge: 1. Christoph, 2. Johannes, 3. Marvin, 4. Benjamin, 5. Udo ---
				</tr>
			</table>
		  </div>'; 

	echo '<div class="draft" id="list">';

		include("spielerliste.php"); 
			
	echo '</div>

	<div class="management" id="own">';
		callManagerkader();

	echo '</div>';
	echo '<div class="other" id="other">';
		callOtherManager();
	echo '</div>

	<br />';
}

echo '</body>
</html>';

function callManagerkader(){

	$manager = $_SESSION["username"];
	$rest = 42.5;
	$anzahl = 0;

	// Datenbank verbinden
	include_once("MySQL_Conn.php");


	// Restbudget für einen Manager berechnen
	$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	while($row_sum = mysql_fetch_row($budget)){
		$rest = $rest - $row_sum [0];
	}

	// Anzahl bisher ausgewählter Spieler eines Managers
	$spieler_count=mysql_query("SELECT COUNT(Nachname) AS `Spieler` FROM `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')")or die(mysql_error ());
	while($row_count = mysql_fetch_row($spieler_count)){
		$anzahl = $row_count [0];
	}

	// Bisher gewählte Spieler eines Managers
	$res=mysql_query("SELECT `idPlayer`, `Nachname` , `Verein` , `Position` , `Marktwert` FROM `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')")or die(mysql_error ());

	$count = 1;
	$row_id = '';


	// Anzahl Torhüter auslesen
	$sql_tor=mysql_query("SELECT COUNT(*) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'TOR' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if ( $tor_row = mysql_fetch_row($sql_tor) ){
		$tor = $tor_row [0];
	}
	
	// Anzahl Abwehr auslesen
	$sql_abw=mysql_query("SELECT COUNT(*) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'ABW' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if ( $abw_row = mysql_fetch_row($sql_abw) ){
		$abw = $abw_row [0];
	}

	// Anzahl Mittelfeld auslesen
	$sql_mit=mysql_query("SELECT COUNT(*) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'MIT' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if ( $mit_row = mysql_fetch_row($sql_mit) ){
		$mit = $mit_row [0];
	}
	
	// Anzahl Sturm auslesen
	$sql_stu=mysql_query("SELECT COUNT(*) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'STU' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if ( $stu_row = mysql_fetch_row($sql_stu) ){
		$stu = $stu_row [0];
	}

	$_SESSION["tor"] = $tor;
	$_SESSION["abw"] = $abw;
	$_SESSION["mit"] = $mit;
	$_SESSION["stu"] = $stu;

	// Budget für Spieler pro Position berechnen
	$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'TOR' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if($row_bud = mysql_fetch_row($budget)){
		$bud_tor = $row_bud [0];
	}
	$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'ABW' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if($row_bud = mysql_fetch_row($budget)){
		$bud_abw = $row_bud [0];
	}
	$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'MIT' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if($row_bud = mysql_fetch_row($budget)){
		$bud_mit = $row_bud [0];
	}
	$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `tblSpielerliste` WHERE `Position` = 'STU' AND `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
	if($row_bud = mysql_fetch_row($budget)){
		$bud_stu = $row_bud [0];
	}
	
	// Tabelle für einen Manager schreiben
	echo '<table class="manager" >';
	echo '<tr><th class="header">'.$manager.'</th><th class="header" colspan="2">Spieleranzahl: '.$anzahl.' / 22</th><th class="header">'.$rest.'</th><th class="header"></th></tr>';
	echo '<tr><td class="head">TOR</td><td class="head" colspan="2">Spieleranzahl: '.$tor.' / 3</td><td class="head">'.$bud_tor.'</td><td class="head"></td></tr>';
	echo '<tr><td class="head">ABW</td><td class="head" colspan="2">Spieleranzahl: '.$abw.' / 6</td><td class="head">'.$bud_abw.'</td><td class="head"></td></tr>';
	echo '<tr><td class="head">MIT</td><td class="head" colspan="2">Spieleranzahl: '.$mit.' / 8</td><td class="head">'.$bud_mit.'</td><td class="head"></td></tr>';
	echo '<tr><td class="head">STU</td><td class="head" colspan="2">Spieleranzahl: '.$stu.' / 5</td><td class="head">'.$bud_stu.'</td><td class="head"></td></tr>';
	echo '<tr>';
	echo '<td class="head">Pos.</td><td class="head">Spieler</td><td class="head">Verein</td><td class="head">MW</td><td class="head"></td>';
	echo '</tr>';

	while($row=mysql_fetch_row($res)){

		if($count % 2){
			$row_id = 'row_2';
		}
		else{
			$row_id = 'row_1';
		}
		echo '<tr class="'.$row_id.'">
				<td class="small">'.$row[3].'</td>
				<td class="big">'.$row[1].'</td>
				<td class="big">'.$row[2].'</td>
				<td class="small">'.$row[4].'</td>
				<td class="small"><input type="button" id="'.$row[0].'" value="del" onclick="delPlayer(this)"/></td>';

		echo '</tr>';
		$count++;
	}
	echo '</table>';
}

function callOtherManager(){

	
	$anzahl = 0;
	$manager_count = -1;

	$manager = $_SESSION["username"];

	// Datenbank verbinden
	include_once("MySQL_Conn.php");

	// hole alle Manager aus der Datenbank, die nicht Besitzer der aktuellen Session sind
	$result=mysql_query("SELECT `Name` FROM `tblManager` WHERE `Name` != '".$manager."'")or die(mysql_error ());
	
	// schreibe für alle anderen Manager eine Tabe
	while($name=mysql_fetch_row($result)){

		$rest = 42.5;
		
		// Restbudget für einen Manager berechnen
		$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$name[0]."')") or die(mysql_error ());
		while($row_sum = mysql_fetch_row($budget)){
			$rest = $rest - $row_sum [0];
		}

		// Anzahl bisher ausgewählter Spieler eines Managers
		$spieler_count=mysql_query("SELECT COUNT(Nachname) AS `Spieler` FROM `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$name[0]."')")or die(mysql_error ());
		while($row_count = mysql_fetch_row($spieler_count)){
			$anzahl = $row_count [0];
		}
		$count = 1;
		$manager_count++;
		if($manager_count == 2){
			echo '<br /><br /><br /><br />';
		}
			
		$res=mysql_query("SELECT `Nachname` , `Verein` , `Position` , `Marktwert` FROM `tblSpielerliste` WHERE `Manager` = (SELECT `idManager` FROM `tblManager` WHERE `Name` = '".$name[0]."')")or die(mysql_error ());
		
		// Tabelle für einen Manager schreiben
		echo '<table class="manager" >';
		echo '<tr><th class="header">'.$name[0].'</th><th class="header" colspan="2">Spieleranzahl: '.$anzahl.' / 22</th><th class="header">'.$rest.'</th>';
		echo '<tr>';
		echo '<td class="head">Pos.</td><td class="head">Spieler</td><td class="head">Verein</td><td class="head">MW</td>';
		echo '</tr>';

		while($row=mysql_fetch_row($res)){

			if($count % 2){
				$row_id = 'row_2';
			}
			else{
				$row_id = 'row_1';
			}
			echo '<tr class="'.$row_id.'">
					<td class="small">'.$row[2].'</td>
					<td class="big">'.$row[0].'</td>
					<td class="big">'.$row[1].'</td>
					<td class="small">'.$row[3].'</td>';

			echo '</tr>';
			$count++;
		}
		echo '</table>';
	}

}

?>
