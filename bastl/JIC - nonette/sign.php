<?php
include "app/phpScripts.php";


//sign up
if(isset($_POST['signup']))
{
	//get variables
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$firstName = mysqli_real_escape_string($con,$_POST['firstName']);
	$lastName = mysqli_real_escape_string($con,$_POST['lastName']);
	$password = mysqli_real_escape_string($con,$_POST['password']);
	$repassword = mysqli_real_escape_string($con,$_POST['repassword']);
	$gender = mysqli_real_escape_string($con,$_POST['gender']);

	//sign up
	$error=signup($firstName,$lastName,$email,$password,$repassword,$gender);	

	//echo errors
	if($error==0)
	{
		echo "Můžete se přihlásit.";
		$email="";
		$firstName="";
		$lastName="";
		$password="";
		$repassword="";
		$gender="";
	}
	else
	{
		echo "Registrace se nezdařila. ";
		switch($error)
		{
			case 1:
				echo "Email už existuje.";
			break;
			case 2:
				echo "Formulář obsahuje neplatné znaky.";
			break;
			case 3:
				echo "Všechna pole musí být vyplněna.";
			break;
			case 4:
				echo "Zadaná hesla se neshodují.";
			break;
			case 5:
				echo "Heslo je příliš krátké.";
			break;
			case 6:
				echo "Pohlaví nebylo vyplněno."; echo $gender;
			break;
		}
	}
}
else
{
	$email="";
	$firstName="";
	$lastName="";
	$password="";
	$repassword="";
	$gender="";
}
//sign in
if(isset($_POST['signin']))
{
	//get variables
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$password = mysqli_real_escape_string($con,$_POST['password']);
	//sign in
	$error=signin($email,$password);
	//echo errors
	switch($error)
	{
		case 1:
			echo "Uživatel neexistuje.";
		break;
		case 2:
			echo "Špatné heslo.";
		break;
	}
}

//if is user logged go to index.php
if(isLogged())
{
	header("location:index.php");
}
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <title>Vaříme společně</title>
</head>
<body>
	<!---sign in-->
	<b>Prihlaseni:</b>
	<form action="sign.php" method="post">
		Email: <input type="email" name="email"><br>
		Heslo: <input type="password" name="password"><br>
		<input type="submit" name="signin" value="Prihlasit se"><br>
	</form>

	<hr>
	<b>Registrace:</b>
	<form action="sign.php" method="post">
		Email: <input type="email" name="email" value="<?php echo $email;?>"><br>
		Křestní jméno: <input type="text" name="firstName" value="<?php echo $firstName;?>"><br>
		Příjmení: <input type="text" name="lastName" value="<?php echo $lastName;?>"><br>
		Pohlaví: 
			<select name="gender">
				<option value="m" <?php if($gender=="m"){echo "selected='selected'";}?>>muž</option>
				<option value="f" <?php if($gender=="f"){echo "selected='selected'";}?>>žena</option>
			</select>
		Heslo: <input type="password" name="password"><br>
		Heslo znovu: <input type="password" name="repassword"><br>
		<input type="submit" name="signup" value="Registrovat se"><br>
	</form>
</body>