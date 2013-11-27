<?php 
include "app/phpScripts.php";
if(isset($_GET['logout']))
{logout();}
?>
<b>Akce:</b><br>
<?php
showEvents();
?>
<hr>
<a href="sign.php">Registrovat/Přihlásit</a>
<hr>
<a href="create.php">Vytvořit novou událost</a>
<form action="index.php" method="get">
	<input type="submit" value="Odhlásit" name="logout">
</form>

