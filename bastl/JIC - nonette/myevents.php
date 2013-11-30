<?php
	include "app/phpScripts.php";
	$message="";
	
	if(isLogged())
	{$user_id=$_SESSION['id'];}
	else
	{header("location:index.php");}


?>
<!DOCTYPE>
<html>
	<head>
	    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
	    <title>Vaříme společně</title>
	</head>
	<body>
		<?php echo $message;?>
		<a href="index.php">Menu</a></br>
		<b>Moje akce</b><br>
		 	<table>
		 		<?php showMyEvents($user_id);?>
	 		<table>
		<b>Akce, který se účastním</b><br>
			<table>
		 		<?php showAttendedEvents($user_id);?>
	 		<table>
	</body>