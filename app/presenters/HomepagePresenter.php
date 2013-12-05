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

	}

	public function actionDefault()
	{
		$this->attendees = $this->context->attendeeRepository->findAll();
		// $this->events = $this->context->eventRepository->find(array('user_id' => $this->getUser()->id));

		$this->template->attendees = $this->attendees;
	}
}
