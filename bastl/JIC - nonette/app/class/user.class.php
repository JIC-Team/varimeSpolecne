<?php
class user
{
	public $id;
	public $firstName;
	public $lastName;
	public $password;
	public $email;
	public $gander;
	public $date;

	public function __construct ($id)
    {
    	$this->id=$id;
    	$this->firstName=selectWhere("first_name","user","id",$this->id);
    	$this->lastName=selectWhere("last_name","user","id",$this->id);
    	$this->email=selectWhere("email","user","id",$this->id);
    	$this->password=selectWhere("password","user","id",$this->id);
    	$this->gander=selectWhere("gender","user","id",$this->id);
    	$this->date=selectWhere("date","user","id",$this->id);
    }

    //approve user
    public function approve($id)
    {
    	$error=0;
    	

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

    //attend event
    public function attend($event_id)
    {
    	$error=0;
        $user_id=$this->id;

        if(exist("attendee","event_id",$event_id))
        {
            include "app/config.php";
            $result = mysqli_query($con,"SELECT * from attendee where event_id=$event_id")or die (mysqli_error($con));
            $parti=mysqli_num_rows($result);
            $participation = $parti;       
            
        }
        else
        {
            $participation=0;
        }
        $max_people=selectWhere("max_people","event","id",$event_id);
        


        if(exist2("attendee","event_id",$event_id,"user_id",$user_id)){$error=1;}
        else if(!exist("event","id",$event_id)){$error=2;}
        else if($max_people<=$participation){$error=3;}
        else
        {
            include "app/config.php";
            mysqli_query($con,"INSERT INTO attendee (event_id,user_id) VALUES ('$event_id','$user_id')")or die(mysql_error());
        }

        return $error;
    }

    //leave event
    public function leave($event_id)
    {
    	$error=0;
    	
        $user_id=$this->id;

        if(!exist2("attendee","event_id",$event_id,"user_id",$user_id)){$error=1;}
        else
        {
            include "app/config.php";
            mysqli_query($con,"DELETE FROM attendee WHERE user_id=$user_id AND event_id=$event_id")or die(mysql_error());
        }

        return $error;
    }

}