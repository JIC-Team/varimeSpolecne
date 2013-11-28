<?php
include "config.php";
session_start();
////////////////////////just f
//just for shorter code
function selectWhere($x,$from,$where,$y)
{
	include "config.php";
 	$text_mysql = mysqli_query($con,"SELECT * FROM $from where $where = $y");
 	$text_row = mysqli_fetch_array($text_mysql);
 	$text = $text_row[$x];
 	return $text;
}
//shorten text (full words), to x characters
function shorter($text,$characters)
{
	
	if(strlen($text)>$characters)
	{
		$pos=strpos($text,' ', $characters);
		return (substr($text,0,$pos))."...";	
	}
	else
	{
		return $text;
	}
}
//check if row exist, just for shorter code
function exist($from,$where,$y)
{
	include "config.php";
	$result = mysqli_query($con,"SELECT * from $from where $where = '$y' LIMIT 1")or die (mysqli_error($con));

	if(mysqli_num_rows($result)>0)
	{

	    return true;
	}
	else
	{
		return false;
	}
}


//loads all classes
foreach (glob("app/class/*class.php") as $filename)
{
    include $filename;
}

/////////////////////////////////events actions////////////////////////////////////////
//show events
function showEvents()
{
    //more features will be included
    include "config.php";
    $mysql = mysqli_query($con,"SELECT * FROM event");
    while($row = mysqli_fetch_array($mysql))
    {
		$des=shorter($row['description'],30); 
        echo "<tr><td>{$row['title']}'</td><td>{$des}</td><td><a href='event.php?id={$row['id']}'´>Zobrazit info/Zúčastnit se</td></tr>";
    }
}

//create event
function create($user_id,$title,$discription,$date,$food,$max_people)
{
	$error=0;
	
    //code

    if($error==0)
	{
		return "Akce vytvořena";
	}
	else
	{
		return "Akci nelze vytvořit, protože...";
	}
}
/////////////////////////////////user actions////////////////////////////////////////
//check if user is logged
function isLogged()
{
	if(isset($_SESSION["id"]))
	{
		return true;
	}
	else
	{
		return false;
	}
}

//signup
function signup($firstName,$lastName,$email,$password,$repassword,$gender)
{
	$error=0;
	
	if(exist("user","email",$email)){$error=1;}
	else if(preg_match('<|>', $firstName)){$error=2;}
	else if(preg_match('<|>', $lastName)){$error=2;}
	else if(preg_match('<|>', $email)){$error=2;}
	else if($gender!=="m" && $gender!=="f"){$error=6;}
    else if($firstName==""){$error=3;}
    else if($password==""){$error=3;}
    else if($password!=$repassword){$error=4;}
    else if($email==""){$error=3;}
    else if($gender==""){$error=3;}
    else if(strlen($password) < 4){$error=5;}
    else
    {
    	include "config.php";
    	$hash = password_hash($password, PASSWORD_DEFAULT);
    	mysqli_query($con,"INSERT INTO user (password, first_name, last_name, email, gender) VALUES ('$hash','$firstName','$lastName','$email','$gender')");
    //	mysqli_query($con,"INSERT INTO user (password, first_name, last_name, email, gender) VALUES ('$hash','$firstName','$lastName','$email','$gender')");
    }


	return $error;
}

//signin
function signin($email,$password)
{
	$error=0;
	include "config.php";
	$mysql=mysqli_query($con,"SELECT * FROM user where email='$email'")or die (mysqli_error($con));

	if(mysqli_num_rows($mysql)>0)
	{
		$row=mysqli_fetch_array($mysql);

		if (password_verify($password, $row['password'])) {
			$_SESSION['id']=$row['id'];
			return 0;
		}
		else {
		   return 2;
		}
	}
	else
	{
		return 1;
	}


	//code

	if($error==0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function logout()
{
	unset($_SESSION['id']);
	session_destroy();
}

function showLoggedUser($column)
{
	if(isLogged())
	{
	$id=$_SESSION['id'];
	$user=New user($id);
	return $user->$column;
	}	
	else
	{return "";}
}



