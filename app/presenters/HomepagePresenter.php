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

	public function attendeeCount($id)
	{
		$attendeeCount = 0;
		foreach($this->context->attendeeRepository->findAll() as $attendee)
		{
			if($attendee->event_id == $id && $attendee->approved == 1)
				$attendeeCount++;
		}
		return $attendeeCount;
	}
}
