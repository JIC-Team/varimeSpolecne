<?php 
include "app/phpScripts.php";
//if not logged go to index.php
if(!isLogged())
{header("location:index.php");}

//create
if(isset($_POST['create']))
{
	//code for create
	$user_id=$_SESSION['id'];
	$title = mysqli_real_escape_string($con,$_POST['title']);
	$description = mysqli_real_escape_string($con,$_POST['description']);
	$food = mysqli_real_escape_string($con,$_POST['food']);
	$place = mysqli_real_escape_string($con,$_POST['place']);
	$max_people = mysqli_real_escape_string($con,$_POST['max']);
	$day= mysqli_real_escape_string($con,$_POST['day']);
	$month= mysqli_real_escape_string($con,$_POST['month']);
	$year= mysqli_real_escape_string($con,$_POST['year']);
	$hour= mysqli_real_escape_string($con,$_POST['hour']);
	
	$error=create($user_id,$title,$description,$food,$max_people,$place,$hour,$day,$month,$year);
	if($error==0)
	{
		$message = "Akce byla vytvořena.";
		$title="";
		$food="";
		$max_people="";
		$description="";
		$date="";
		$place="";
		$day="";
		$month="";
		$year="";
		$hour="";
	}
	else
	{
		$message="Chyba, ";
		switch($error)
		{
			case 1:
				$message=$message."do počtu účastníků musíte napsat číselné hodnoty.";
			break;
			case 2:
				$message=$message."obsahuje nepovolené znaky.";
			break;
			case 3:
				$message=$message."musíte vyplnit všechna pole.";
			break;
			case 4:
				$message=$message."obsahuje neplatné datum.";
			break;
			case 5:
				$message=$message."nemůžete mít dvě akce ve stejný čas.";
			break;
		}	
	}
}
else
{	
	$message="";
	$title="";
	$food="";
	$max_people="";
	$description="";
	$date="";
	$place="";
	$day="";
	$month="";
	$year="";
	$hour="";
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
	<form action="create.php" method="POST">
		<!--type number funguje jen v chromu, mělo by se to dodělat v js--> 
		Název:<input type="text" name="title" value="<?php echo $title;?>"><br>
		Popis:<br>
		<textarea rows="5" name="description"><?php echo $description;?></textarea><br>
		Jídlo:<input type="text" name="food" value="<?php echo $food;?>"><br>
		MAximální počet účastníků:<input type="number" name="max" value="<?php echo $max_people;?>"><br>
		Místo:<input type="text" name="place" value="<?php echo $place;?>"><br>
		Datum: 
		čas:
			<select name="hour" value="15:00">
				<option value="1" <?php if($hour=="1"){echo "selected='selected'";}?>>1:00</option>
				<option value="2" <?php if($hour=="2"){echo "selected='selected'";}?>>2:00</option>
				<option value="3"<?php if($hour=="3"){echo "selected='selected'";}?>>3:00</option>
				<option value="4"<?php if($hour=="4"){echo "selected='selected'";}?>>4:00</option>
				<option value="5"<?php if($hour=="5"){echo "selected='selected'";}?>>5:00</option>
				<option value="6"<?php if($hour=="6"){echo "selected='selected'";}?>>6:00</option>
				<option value="7"<?php if($hour=="7"){echo "selected='selected'";}?>>7:00</option>
				<option value="8"<?php if($hour=="8"){echo "selected='selected'";}?>>8:00</option>
				<option value="9"<?php if($hour=="9"){echo "selected='selected'";}?>>9:00</option>
				<option value="10"<?php if($hour=="10"){echo "selected='selected'";}?>>10:00</option>
				<option value="11"<?php if($hour=="11"){echo "selected='selected'";}?>>11:00</option>
				<option value="12"<?php if($hour=="12"){echo "selected='selected'";}?>>12:00</option>
				<option value="13"<?php if($hour=="13"){echo "selected='selected'";}?>>13:00</option>
				<option value="14"<?php if($hour=="14"){echo "selected='selected'";}?>>14:00</option>
				<option value="15"<?php if($hour=="15"){echo "selected='selected'";}?>>15:00</option>
				<option value="16"<?php if($hour=="16"){echo "selected='selected'";}?>>16:00</option>
				<option value="17"<?php if($hour=="17"){echo "selected='selected'";}?>>17:00</option>
				<option value="18"<?php if($hour=="18"){echo "selected='selected'";}?>>18:00</option>
				<option value="19"<?php if($hour=="19"){echo "selected='selected'";}?>>19:00</option>
				<option value="20"<?php if($hour=="20"){echo "selected='selected'";}?>>20:00</option>
				<option value="21"<?php if($hour=="21"){echo "selected='selected'";}?>>21:00</option>
				<option value="22"<?php if($hour=="22"){echo "selected='selected'";}?>>22:00</option>
				<option value="23"<?php if($hour=="23"){echo "selected='selected'";}?>>23:00</option>
				<option value="24"<?php if($hour=="24"){echo "selected='selected'";}?>>24:00</option>
			</select>

		den: 
			<select name="day">
				<option value="1"<?php if($day=="1"){echo "selected='selected'";}?>>1</option>
				<option value="2"<?php if($day=="2"){echo "selected='selected'";}?>>2</option>
				<option value="3"<?php if($day=="3"){echo "selected='selected'";}?>>3</option>
				<option value="4"<?php if($day=="4"){echo "selected='selected'";}?>>4</option>
				<option value="5"<?php if($day=="5"){echo "selected='selected'";}?>>5</option>
				<option value="6"<?php if($day=="6"){echo "selected='selected'";}?>>6</option>
				<option value="7"<?php if($day=="7"){echo "selected='selected'";}?>>7</option>
				<option value="8"<?php if($day=="8"){echo "selected='selected'";}?>>8</option>
				<option value="9"<?php if($day=="9"){echo "selected='selected'";}?>>9</option>
				<option value="10"<?php if($day=="10"){echo "selected='selected'";}?>>10</option>
				<option value="11"<?php if($day=="11"){echo "selected='selected'";}?>>11</option>
				<option value="12"<?php if($day=="12"){echo "selected='selected'";}?>>12</option>
				<option value="13"<?php if($day=="13"){echo "selected='selected'";}?>>13</option>
				<option value="14"<?php if($day=="14"){echo "selected='selected'";}?>>14</option>
				<option value="15"<?php if($day=="15"){echo "selected='selected'";}?>>15</option>
				<option value="16"<?php if($day=="16"){echo "selected='selected'";}?>>16</option>
				<option value="17"<?php if($day=="17"){echo "selected='selected'";}?>>17</option>
				<option value="18"<?php if($day=="18"){echo "selected='selected'";}?>>18</option>
				<option value="19"<?php if($day=="19"){echo "selected='selected'";}?>>19</option>
				<option value="20"<?php if($day=="20"){echo "selected='selected'";}?>>20</option>
				<option value="21"<?php if($day=="21"){echo "selected='selected'";}?>>21</option>
				<option value="22"<?php if($day=="22"){echo "selected='selected'";}?>>22</option>
				<option value="23"<?php if($day=="23"){echo "selected='selected'";}?>>23</option>
				<option value="24"<?php if($day=="24"){echo "selected='selected'";}?>>24</option>
				<option value="25"<?php if($day=="25"){echo "selected='selected'";}?>>25</option>
				<option value="26"<?php if($day=="26"){echo "selected='selected'";}?>>26</option>
				<option value="27"<?php if($day=="27"){echo "selected='selected'";}?>>27</option>
				<option value="28"<?php if($day=="28"){echo "selected='selected'";}?>>28</option>
				<option value="29"<?php if($day=="29"){echo "selected='selected'";}?>>29</option>
				<option value="30"<?php if($day=="30"){echo "selected='selected'";}?>>30</option>
				<option value="31"<?php if($day=="31"){echo "selected='selected'";}?>>31</option>
			</select>
			měsíc:
			<select name="month">
				<option value="1" <?php if($month=="1"){echo "selected='selected'";}?>>leden</option>
				<option value="2"<?php if($month=="2"){echo "selected='selected'";}?>>únor</option>
				<option value="3"<?php if($month=="3"){echo "selected='selected'";}?>>březen</option>
				<option value="4"<?php if($month=="4"){echo "selected='selected'";}?>>duben</option>
				<option value="5"<?php if($month=="5"){echo "selected='selected'";}?>>květen</option>
				<option value="6"<?php if($month=="6"){echo "selected='selected'";}?>>červen</option>
				<option value="7"<?php if($month=="7"){echo "selected='selected'";}?>>červenc</option>
				<option value="8"<?php if($month=="8"){echo "selected='selected'";}?>>srpen</option>
				<option value="9"<?php if($month=="9"){echo "selected='selected'";}?>>září</option>
				<option value="10"<?php if($month=="10"){echo "selected='selected'";}?>>říjen</option>
				<option value="11"<?php if($month=="11"){echo "selected='selected'";}?>>listopad</option>
				<option value="12"<?php if($month=="12"){echo "selected='selected'";}?>>prosinec</option>
			</select>
			rok:
			<select name="year">
				<option value="2013"?>2013</option>
				<option value="2014"?>2014</option>
			</select>

		<input type="submit" name="create" value="Vytvořit akci">
	</form>
</body>