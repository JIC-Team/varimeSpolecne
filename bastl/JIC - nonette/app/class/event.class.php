<?php

class Event
{
	public $date;
	public $user_id;
	public $food;
	public $discription;
	public $title;
	public $max_people;
	public $id;

    //
    public function __construct ($id)
    {
    	$this->id=$id;
    	$this->title=selectWhere("title","event","id",$this->id);
    	$this->user_id=selectWhere("user_id","event","id",$this->id);
    	$this->description=selectWhere("description","event","id",$this->id);
    	$this->max_people=selectWhere("max_people","event","id",$this->id);
    	$this->date=selectWhere("date","event","id",$this->id);
    	$this->food=selectWhere("food","event","id",$this->id);
    }


    //set variables
    public function initialize()
    {

    }

    //return info
    public function info()
    {
		//chief name
		$user_id=$this->user_id;
		$user_name=selectWhere("first_name","user","id",$user_id);


		echo $this->title."<br>";
		echo $this->description."<br>";
		echo $this->food."<br>";
		echo $user_name."</br>";
		echo $this->max_people."<br>";
    }

    //create event
    public function create($user_id,$title,$discription,$date,$food,$max_people)
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