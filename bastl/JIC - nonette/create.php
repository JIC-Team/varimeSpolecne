<?php 
include "app/phpScripts.php";
//if not logged go to index.php
if(!isLogged())
{header("location:index.php");}

//create
if(isset($_POST['create']))
{
	//code for create
	//1. get variables
	//2. call function
	//3. echo error

}

?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <title>Vaříme společně</title>
</head>
<body>
	<form action="create.php">
		<!--type number funguje jen v chromu, měli by se to dodělat v js--> 
		Název:<input type="text" name="title"><br>
		Popis:<input type="text" name="description"><br>
		Jídlo:<input type="text" name="food"><br>
		MAximální počet účastníků:<input type="number" name="max"><br>
		Místo:<input type="text" name="place"><br>
		Datum: den: <input type="number" name="day"> měsíc: <input type="number" name="month"> rok: <input type="number" name="year"><br>
		<input type="submit" name="create" value="Vytvořit akci">
	</form>
</body>