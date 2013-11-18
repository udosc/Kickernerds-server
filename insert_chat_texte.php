<?php 

session_start();
$user = $_SESSION["username"];

include_once("MySQL_Conn.php"); 

if($_POST[nachricht] == "") 
  { 
	include_once ("form_chat_texte.php"); 
  } 
  else 
  { 
	  $zeit = time(); 
	  
	  $eintrag = "INSERT INTO chat (absender, nachricht, time) 
					VALUES ('".$user."', '$_POST[nachricht]', '$zeit')"; 
	  $eintragen = mysql_query($eintrag); 
	 
	  include("pick.php"); 
  }
?>
