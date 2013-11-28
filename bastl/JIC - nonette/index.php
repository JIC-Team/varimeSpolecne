<?php 
include "app/phpScripts.php";

?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <title>Vaříme společně</title>
</head>
<body>
	<?php if(isLogged()){echo "přhlášený uživatel: ".showLoggedUser("firstName")."<br>";}?>
	<b>Akce:</b><br>
	<table>
	<?php
		showEvents();
	?>
	</table>
	<hr>
	<a href="sign.php">Registrovat/Přihlásit</a>
	<hr>
	<a href="create.php">Vytvořit novou událost</a>
	<hr>
	<a href="app/logOut.php">Odhlásit se</a>
</body>

