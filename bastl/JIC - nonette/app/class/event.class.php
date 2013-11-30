<?php

class Event
{
	public $date;
	public $user_id;
	public $food;
    public $place;
	public $discription;
	public $title;
	public $max_people;
	public $id;
    public $user_name;
    public $participation;
    //
    public function __construct ($id)
    {
    	$this->id=$id;
    	$this->title=selectWhere("title","event","id",$this->id);
    	$this->user_id=selectWhere("user_id","event","id",$this->id);
    	$this->description=selectWhere("description","event","id",$this->id);
    	$this->max_people=selectWhere("max_people","event","id",$this->id);
    	$this->date=selectWhere("date","event","id",$this->id);
        $this->place=selectWhere("place","event","id",$this->id);
    	$this->food=selectWhere("food","event","id",$this->id);        
        $this->user_name=selectWhere("first_name","user","id",$this->user_id);
        

        
        if(exist("attendee","event_id",$id))
        {
            include "app/config.php";
            $result = mysqli_query($con,"SELECT * from attendee where event_id=$id")or die (mysqli_error($con));
            $parti=mysqli_num_rows($result);
            $this->participation = $parti;       
            
        }
        else
        {
            $this->participation=0;
        }
        
    }
        


    //return info
    public function info($column)
    {
        switch ($column) {
            case 'title':
                echo $this->title;
            break;
            case 'description':
                echo $this->description;
            break;
            case 'food':
                echo $this->food;
            break;
            case 'place':
                echo $this->place;
            break;
            case 'date':
                echo $this->date;
            break;
            case 'max_people':
                echo $this->max_people;
            break;
            case 'user_name':
                echo $this->user_name;
            break;
            case 'participation':
                echo $this->participation;
            break;
            case 'id':
                echo $this->id;
            break;
        }
    }



    //delete event
    public function delete($user_id)
    {
    	$error=0;

        //code

    	if($error==0)
    	{
    		return "Akce smazána.";
    	}
    	else
    	{
    		return "Akci nelze smazat";
    	}
    }
}