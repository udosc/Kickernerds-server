<?php
echo '
<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
	@import "style.css";
</style>
<script type="text/javascript" src="dragndrop.js"></script>
<script src="sorttable.js"></script>
<body>

<div class="topleft" ondrop="drop(event)" ondragover="allowDrop(event)">
<img  src="logo.png" id="drag1" draggable="true" ondragstart="drag(event)"/>
</div>

<div class="form">
<form action="login.php" method="post">
Dein Username:<br>
<input type="text" size="24" maxlength="50"
name="username"><br><br>
<input type="submit" value="Login">
</form>
</div>
<br />

</body>
</html>';
?>

