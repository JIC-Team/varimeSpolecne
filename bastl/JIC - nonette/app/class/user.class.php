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

    //signup
    public function signup($firstName,$lastName,$email,$password,$gender)
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

    //signin
    public function signin($email,$password)
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
    public function attend($id)
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

    //leave event
    public function leave($id)
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

}