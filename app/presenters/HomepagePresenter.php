<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	function startup() {
		parent::startup();
	}

	public function renderDefault()
	{
		$this->template->attendees = $this->context->attendeeRepository->findAll();
		$this->template->events = $this->context->eventRepository->findAll();
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
