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
		$this->events = $this->context->eventRepository->find(array('user_id' => $this->getUser()->id));

		$this->attendees = array();
		foreach($this->context->attendeeRepository->findAll() as $attendee)
		{
			foreach($this->events as $event)
			{
				if($event->id == $attendee->event_id)
					$this->attendees[] = $this->context->userRepository->find(array('id' => $attendee->user_id));
			}
		}

		$this->template->notifications = $this->notifications;
	}
}
