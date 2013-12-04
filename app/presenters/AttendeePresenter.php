<?php

/**
* 
*/
class AttendeePresenter extends BasePresenter
{
	private $attendeeRespository;

	protected function startup()
	{
		parent::startup();
		if(!$this->getUser()->isLoggedIn()){
		  $this->redirect('Sign:in');
    	}

    	$this->attendeeRespository = $this->context->attendeeRespository->findAll();
	}

	public function renderDefault()
	{
		
	}

	public function actionDefault()
	{
		
	}
}