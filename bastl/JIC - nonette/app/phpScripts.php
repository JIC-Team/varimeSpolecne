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

//check if row exist, just for shorter code
function exist2($from,$where,$y,$where2,$x)
{
	include "config.php";
	$result = mysqli_query($con,"SELECT * from $from where $where = '$y' AND $where2 = '$x' LIMIT 1")or die (mysqli_error($con));

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

function showEvents()
{
	include "app/config.php";
	$mysql = mysqli_query($con,"SELECT * FROM event ORDER by DATE desc");
	while($row = mysqli_fetch_array($mysql))
	{
    	echo "<tr><td>{$row['title']}</td><td>{$row['date']}</td><td>{$row['place']}</td><td><a href='event.php?id={$row['id']}'´>Zobrazit info/Zúčastnit se</td></tr>";
	}
}

function showMyEvents($user_id)
{
	include "app/config.php";
	$mysql = mysqli_query($con,"SELECT * FROM event WHERE user_id=$user_id ORDER by DATE desc");
	while($row = mysqli_fetch_array($mysql))
	{
		
    	echo "<tr><td>{$row['title']}</td><td>{$row['date']}</td><td><a href='event.php?id={$row['id']}'>Zobrazit info<a/></td></tr>";
	}
}

function showAttendedEvents($user_id)
{
	include "app/config.php";
	$mysql_attendee = mysqli_query($con,"SELECT * FROM attendee WHERE user_id=$user_id");
	while($row_attendee = mysqli_fetch_array($mysql_attendee))
	{
		$event_id=$row_attendee['event_id'];
		$event=new Event($event_id);

    	echo "<tr><td>{$event->title}</td><td>{$event->date}</td><td><a href='event.php?id={$event->id}'>Zobrazit info<a/></td></tr>";
	}
}

//create event
function create($user_id,$title,$description,$food,$max_people,$place,$hour,$day,$month,$year)
{
	
    include "config.php";
	$error=0;    	

	$string =$day.".".$month.".".$year." ".$hour;
	$time = mktime($hour,0,0,$month,$day,$year);
	$time=date("Y-m-d H:i:s", $time);
	
	if(!preg_match('<|>', $title)){$error=2;}
	else if(preg_match('/<|>/', $description)){$error=2;}
	else if(preg_match('/<|>/', $food)){$error=2;}
	else if(preg_match('/<|>/', $place)){$error=2;}
	else if(preg_match('/[0-9]/', $max_people)){$error=1;}
	else if(preg_match('/[0-9]/', $day)){$error=1;}
	else if(preg_match('/[0-9]/', $year)){$error=1;}
	else if(preg_match('/[0-9]/', $month)){$error=1;}
	else if(preg_match('/[0-9]/', $hour)){$error=1;}
	else if(exist2("event","user_id",$user_id,"date",$time)){$error=5;}
	else if($month>12){$error=4;}
	else if($day>31){$error=4;}
	else if($hour>24){$error=4;}
    else if($title==""){$error=3;}
    else if($description==""){$error=3;}
    else if($day==""){$error=3;}
    else if($year==""){$error=3;}
    else if($place==""){$error=3;}
    else if($hour==""){$error=3;}
    else if($month==""){$error=3;}
    else if($food==""){$error=3;}
    else if($max_people==""){$error=3;}
    else if($user_id==""){$error=3;}

    else
    {
    	mysqli_query($con,"INSERT INTO event (date,place,max_people,food,title,description,user_id) VALUES ('$time','$place','$max_people','$food','$title','$description','$user_id')");
    }
	return $error;
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
	else if(preg_match('/<|>/', $firstName)){$error=2;}
	else if(preg_match('/<|>/', $lastName)){$error=2;}
	else if(preg_match('/<|>/', $email)){$error=2;}
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



