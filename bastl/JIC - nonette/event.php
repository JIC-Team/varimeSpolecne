<?php 
include "app/phpScripts.php";
if(isset($_POST['attend']) && isset($_POST['id']))
{
	//ís logged?
	if(isLogged())
	{
		//attend

	}
	else
	{
		header("location:sign.php");
	}

}


?>

<b>Info</b><br>

<?php

//show event info
if(isset($_GET['id']) && exist("event","id",$_GET['id']))
{
	$id = $_GET['id'];
	$event = New Event($id);
	$event->info();
}
else
{echo "Tato akce neexistuje";}

?>
<form action="event.php" method="post">
	<input type="submit" name="attend" value="Zúčastnit se">
	<input type="hidden" name="id" value="<?php echo $id;?>">
</form>