<?php

$manager = 'Benjamin';
$rest = 42.5;
$anzahl = 0;

// Datenbank verbinden
include_once("MySQL_Conn.php");

// Restbudget für einen Manager berechnen
$budget=mysql_query("SELECT SUM(Marktwert) AS `Wert` FROM `Spielerliste` WHERE `Manager` = (SELECT `ID` FROM `Manager` WHERE `Name` = '".$manager."')") or die(mysql_error ());
while($row_sum = mysql_fetch_row($budget)){
	$rest = $rest - $row_sum [0];
}

// Anzahl bisher ausgewählter Spieler eines Managers
$spieler_count=mysql_query("SELECT COUNT(Nachname) AS `Spieler` FROM `Spielerliste` WHERE `Manager` = (SELECT `ID` FROM `Manager` WHERE `Name` = '".$manager."')")or die(mysql_error ());
while($row_count = mysql_fetch_row($spieler_count)){
	$anzahl = $row_count [0];
}

// Bisher gewählte Spieler eines Managers
$res=mysql_query("SELECT `Nachname` , `Verein` , `Position` , `Marktwert` FROM `Spielerliste` WHERE `Manager` = (SELECT `ID` FROM `Manager` WHERE `Name` = '".$manager."')")or die(mysql_error ());

$count = 1;
$row_id = '';

// Tabelle für einen Manager schreiben
echo '<table class="manager" >';
echo '<th class="header">'.$manager.'</th><th class="header" colspan="2">Spieleranzahl: '.$anzahl.' / 22</th><th class="header">'.$rest.'</th>';
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
			<td class="cell_1">'.$row[0].'</td>
			<td class="verein">'.$row[1].'</td>
			<td class="small">'.$row[2].'</td>
			<td class="small">'.$row[3].'</td>
			<td class="small">'.$row[4].'</td>
			<td><input type="button" value="remove" onklick="removePlayer()" /></td>';

	echo '</tr>';
	$count++;
}
echo '</table>';

?>
