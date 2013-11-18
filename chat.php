<?php 
echo "<frameset rows=\"80%,20%\">"; 
echo "<frame src=\"ausgabe_chat_texte.php?user=$_GET[user]\">"; 
    echo "<frame src=\"insert_chat_texte.php?user=$_GET[user]\">"; 
    echo "</frameset>"; 
?>
