<?php
session_start();

// Datenbank verbinden
include_once("MySQL_Conn.php");
// Alle noch verfügbaren Spieler aus DB auslesen
$res=mysql_query("SELECT `idPlayer`, `Position`, `Nachname` , `Verein` , `Marktwert` , `PVorjahr` FROM `tblSpielerliste` WHERE `Manager` = 0")or die(mysql_error ());

$count = 1;
$row_id = '';

// Tabelle mit allen verfügbaren Spielern schreiben
echo '<table class="spielerliste">';
echo '<tr><th class="header">Pos.</th><th class="header">Spieler</th><th class="header">Verein</th><th class="header">MW</th><th class="header">P.VJ</th><th class="header"></th></tr>';

while($row=mysql_fetch_row($res)){

	if($count % 2){
		$row_id = 'row_2';
	}
	else{
		$row_id = 'row_1';
	}
	echo '<tr class="'.$row_id.'">
			<td class="small">'.$row[1].'</td>
			<td class="cell_1">'.$row[2].'</td>
			<td class="big">'.$row[3].'</td>
			<td class="small">'.$row[4].'</td>
			<td class="small">'.$row[5].'</td>
			<td class="small"><input type="button" id="'.$row[0].'" value="add" onclick="addPlayer(this)"/></td>';

	echo '</tr>';
	$count++;
}
echo '</table>';

?>
