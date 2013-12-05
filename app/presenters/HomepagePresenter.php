<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	private $events;
	private $attendees;

	private $notifications;

	private $user;

	function startup() {
		parent::startup();

		$this->notifications = array();
	}

	public function renderDefault()
	{
		$this->template->attendees = $this->context->attendeeRepository->findAll();
	}

	public function actionDefault()
	{
		
	}
}
