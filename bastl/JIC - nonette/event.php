<?php 
include "app/phpScripts.php";
$message="";	

$event_id = $_GET['id'];
//set user_id
if(isLogged())
{
	$user_id=$_SESSION['id'];
}
else
{
	$user_id="";
}

//go to index.php if event does not exist
if(isset($_GET['id']) && exist("event","id",$_GET['id']))
{
	$event = New Event($event_id);
}
else
{header("location:index.php");}

//attend to event
if(isset($_POST['attend']) && isset($_GET['id']))
{
	//ís logged?
	if(isLogged())
	{
		$user=New user($user_id);
		$error=$user->attend($event_id);

		if($error==0)
		{
			$message="Přihlásil jste se k akci.";
		}
		else
		{
			$message="Chyba, ";
			switch($error)
			{
				case 1:
					$message=$message."této akce se už účastníte.";
				break;
				case 2:
					$message=$message."tato akce neexistuje.";
				break;
				case 3:
					$message=$message."na této akci už není místo.";
				break;
			}
		}	
	}
	else
	{
		header("location:sign.php");
	}
}
//leave event
if(isset($_POST['leave']) && isset($_GET['id']))
{
	if(isLogged())
	{
		$user=New user($user_id);
		$error=$user->leave($event_id);	

		if($error==0)
		{
			$message="Odhlásili jste se z akce.";
		}
		else
		{
			$message="Chyba, ";
			switch($error)
			{
				case 1:
					$message=$message."Této akce se neúčastníte.";
				break;
			}
		}	
	}
	else
	{
		header("location:index.php");
	}

}
?>
<!DOCTYPE>
<html>
	<head>
	    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
	    <title>Vaříme společně</title>
	</head>
	<body>
	<?php echo $message;?>
	<a href="index.php">Menu</a>
	<b>Info</b><br>
	<?php
		//show event info - rozdělit
		$event->info("title");echo "<br>";
		$event->info("user_name");echo "<br>";
		$event->info("description");echo "<br>";
		$event->info("date");echo "<br>";
		$event->info("participation");echo "/";
		$event->info("max_people");echo "<br>";
	?>

	<?php
	if(!exist2("attendee","event_id",$event_id,"user_id",$user_id) && isLogged()){
	?>
		<form action="event.php?id=<?php echo $event_id;?>" method="post">
			<input type="submit" name="attend" value="Zúčastnit se">
		</form>
	<?php
	}else if(isLogged()){
	?>
		<form action="event.php?id=<?php echo $event_id;?>" method="post">
			<input type="submit" name="leave" value="opustit akci">
		</form>
	<?php 
	}
	?>
	sdílet akci:
	<input type="text" value="varimespolecne.cz/event.php?id=<?php echo $event->info("id");?>">

<body>