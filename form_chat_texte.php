<?php 
session_start();

$user = $_SESSION["username"];

include_once ("MySQL_Conn.php");
include_once ("pick.php"); 
  
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">"; 
echo "<form action=\"insert_chat_texte.php?user=".$user."\" method=\"post\">"; 
echo "Nachricht: <input size=\"40\" name=\"nachricht\" type=\"text\"> "; 
echo "<input value=\"Absenden\" type=\"submit\"><br>"; 
echo "</form>"; 

echo "Online: "; 
$abfrage = "SELECT * FROM online"; 
$ergebnis = mysql_query($abfrage)or die(mysql_error()); 
while($row = mysql_fetch_object($ergebnis)) 
  { 
  echo "$row->user, "; 
  } 
   
?>
