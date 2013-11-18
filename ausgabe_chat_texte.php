<?php 
  session_start();
  
  $user = $_SESSION["username"];
  // Datenbank verbinden
	include_once("MySQL_Conn.php");


  $result = mysql_query("SELECT * FROM online WHERE user = '".$user."'"); 
  $menge = mysql_num_rows($result); 
  if($menge == 0) 
    { 
    $zeit = time(); 
    $eintrag = "INSERT INTO online (user, time) 
                VALUES ('".$user."','$zeit')"; 
    $eintragen = mysql_query($eintrag); 
   
    $eintrag = "INSERT INTO chat (absender, nachricht, time) 
                  VALUES ('System', '".$user." ist Online', '$zeit')"; 
    $eintragen = mysql_query($eintrag); 
    echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
    } 
    else 
    { 
    $abfrage = "SELECT * FROM chat ORDER BY id DESC LIMIT 25"; 
    $ergebnis = mysql_query($abfrage); 
    while($row = mysql_fetch_object($ergebnis)) 
      { 
        $zeit = $row->zeit; 
        $absender = $row->absender; 
        $nachricht = $row->nachricht; 
        echo '<link rel="stylesheet" type="text/css" href="style.css">'; 
        echo '<div>'; 
	if( $absender == 'Udo' ){
		echo '<span style="color:blue">';
	} else if( $absender == 'Benjamin' ){
		echo '<span style="color:olive">';
	} else if( $absender == 'Marvin' ){
		echo '<span style="color:teal">';
	} else if( $absender == 'Johannes' ){
		echo '<span style="color:green">';
	} else if( $absender == 'Christoph' ){
		echo '<span style="color:fuchsia">';
	} else {
		echo '<span style="color:black">';
	}
        echo $absender.': '. $nachricht.'<br />'; 
	echo '</span>';
        echo '</div>'; 
      } 
    } 
?>
