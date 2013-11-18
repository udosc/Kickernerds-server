<?php 
//Verbindung zur MySQL Datenbank 
$verbindung = @ mysql_connect ( 'localhost', '778149_kicker', 'marley83')
    or die (mysql_error()); 

mysql_select_db("kickernerdsdraft_zxq_kickernerdsdraft") 
    or die (mysql_error()); 
?>
