<?php

use Nette\Application\UI\Form,
	Vodacek\Forms\Controls\DateInput;

/**
* Event presenter
*/
class EventPresenter extends BasePresenter
{
	private $id = null;

	public function startup()
	{
		parent::startup();

		if(!$this->getUser()->isLoggedIn()){
		  $this->redirect('Sign:in');
    	}   
	}

	public function renderDefault()
	{
		$this->template->events = $this->context->eventRepository->findAll()->order('date DESC');
		$this->template->attendees = $this->context->attendeeRepository->findAll();
		$this->template->userId = $this->user->id;
	}
	
	public function renderView($id)
	{
		$this->template->events = $this->context->eventRepository->find(array('id' => $id));
		$this->template->userId = $this->user->id;
		$this->template->eventId = $id;
		$this->template->attendees = $this->context->attendeeRepository->find(array('event_id' => $id));
		$this->template->attending = $this->isAttending($id);
		$this->template->attendeeCount = $this->attendeeCount($id);
	}

	public function renderEdit($id)
	{
		$this->template->events = $this->context->eventRepository->find(array('id' => $id));
	}

	public function actionEdit($id)
	{
		$this->events = $this->context->eventRepository->find(array('id' => $id));
		$this->id = $id;
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

	private function isAttending($id)
	{
		foreach($this->context->attendeeRepository->findAll() as $attendee)
		{
			if($attendee->user_id == $this->user->id && $attendee->event_id == $id)
				if($attendee->approved == 0)
					return 0;
				else if($attendee->approved == 1)
					return 1;
				else if($attendee->approved == 2)
					return 2;
		}

		return false;
	}

	public function handleAttend($userId, $eventId)
	{
		$this->context->attendeeRepository->addAttendee($userId, $eventId);
		$this->flashMessage('Chcete se účastnit.');
		$this->redirect('Event:view', $eventId);
	}

	public function handleDelete($id)
	{
		$this->context->attendeeRepository->delete($id);
		$this->context->eventRepository->delete($id);
		$this->flashMessage('Smazali jste událost');
		$this->redirect('Event:default');
	}


	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function handleApprove($attendeeId, $approval, $first, $last)
	{
		if($approval == 'yes')
		{
			$this->context->attendeeRepository->setApproval($attendeeId, 1);
			$this->flashMessage('Schválili jste účast pro '.$first.' '.$last);
		}
		else if($approval == 'no')
		{
			$this->context->attendeeRepository->setApproval($attendeeId, 2);
			$this->flashMessage('Zamítli jste účast pro '.$first.' '.$last);
		}
	}

    /**
     * createComponentEventForm
     * 
     * @access public
     *
     * @return Nette\UI\Form
     */
	public function createComponentEventForm()
	{
		$form = new Form();
		$form->addText('place', 'Místo:')
			->addRule(Form::FILLED, 'Vyplňte místo konání')
			->addCondition(Form::FILLED);
		$form->addDate('date', 'Datum:')
		    ->addRule(Form::FILLED, 'Musíte vyplnit datum')
		    ->addRule(Form::VALID, 'Zadané datum je neplatné');
		$form->addText('max_people', 'Maximální počet lidí:')
			->addRule(Form::FILLED, 'Vyplňte kolik lidí chcete pozvat')
			->addRule(Form::INTEGER, 'Musí být číslo')
			->addCondition(Form::FILLED);
		$form->addText('food', 'Jídlo:')
			->addRule(Form::FILLED, 'Vyplňte co chcete vařit')
			->addCondition(Form::FILLED);
		$form->addText('title', 'Název:')
			->addRule(Form::FILLED, 'Vyplňte název události')
			->addCondition(Form::FILLED);
		$form->addTextArea('description', 'Popis:')
			->addRule(Form::FILLED, 'Vyplňte popis události')
			->addRule(Form::MAX_LENGTH, 'Popis je příliš dlouhý', 1000)
			->addCondition(Form::FILLED);

		if($this->id === null)
		{
			$form->addSubmit('create', 'Vytvořit');
			$form->onSuccess[] = $this->eventFormSubmitted;
		}
		else
		{
			$default = array();
			foreach($this->events[$this->id] as $key => $value)
				$default[$key] = $value;
			$form->setDefaults($default);
			$form->addSubmit('create', 'Aktualizovat');
			$form->onSuccess[] = $this->eventFormUpdate;
		}

		return $form;
	}

	public function eventFormUpdate(Form $form)
	{
		$this->context->eventRepository->updateEvent($this->id, $form);
		$this->flashMessage('Událost aktualizována');
		$this->redirect('Event:default');
	}


	public function eventFormSubmitted(Form $form)
	{
		/**
		 * @todo userID
		 */
		// $this->context->eventRepository->createEvent($this->user->id, new \DateTime(), $form->values->place, $form->values->food, $form->values->max_people, $form->values->title, $form->values->description);
		$this->context->eventRepository->createEvent($this->user->id, $form);
		$this->flashMessage('Událost vytvořena');
		$this->redirect('Event:default');
	}
}