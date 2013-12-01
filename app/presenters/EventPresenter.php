<?php

use Nette\Application\UI\Form,
	Vodacek\Forms\Controls\DateInput;

/**
* Event presenter
*/
class EventPresenter extends BasePresenter
{
	private $eventRepository;
	private $attendeeRepository;

	private $list;


	public function startup()
	{
		parent::startup();

		$this->eventRepository = $this->context->eventRepository;
		$this->attendeeRepository = $this->context->attendeeRepository;

		if(!$this->getUser()->isLoggedIn()){
		  $this->redirect('Sign:in');
    	}
	}

	public function myEvents()
	{
		$this->template->myEvents = $this->eventRepository->findEvent(array("user_id" => $this->getUser()->getIdentity()->getId()));
	}

	public function otherEvents()
	{
		$this->template->otherEvents = $this->eventRepository->findEvent(array("NOT user_id" => $this->getUser()->getIdentity()->getId()));
	}

	public function createComponentEventForm()
	{
		$form = new Form();
		$form->addText('place', 'Místo:')
			->addRule(Form::FILLED, 'Vyplňte místo.')
            ->addCondition(Form::FILLED);
		$form->addDate('datetime', 'Datum akce', DateInput::TYPE_DATETIME)
			->addRule(Form::RANGE, null, array(new DateTime('0 month'), new DateTime('+30 day')))
			->addRule(Form::FILLED, 'Vyplňte datum.')
            ->addCondition(Form::FILLED);
		$form->addText('maxPeople', 'Maximální počet lidí:')
			->addRule(Form::INTEGER)
			->addRule(Form::FILLED, 'Vyplňte maximální počet lidí.')
            ->addCondition(Form::FILLED);
		$form->addText('food', 'Jídlo:')
		->addRule(Form::FILLED, 'Vyplňte jídlo.')
            ->addCondition(Form::FILLED);
		$form->addText('title', 'Název:')
			->addRule(Form::FILLED, 'Vyplňte název akce.')
            ->addCondition(Form::FILLED);
		$form->addText('description', 'Popis:')
			->addRule(Form::FILLED, 'Vyplňte popis')
            ->addCondition(Form::FILLED);
		$form->addSubmit('create', 'Vytvořit');

		$form->onSuccess[] = $this->eventFormSubmitted;

		return $form;
	}

	public function eventFormSubmitted(Form $form)
	{
		$this->eventRepository->createEvent($this->getUser()->getIdentity()->id, $form->values);
		$this->flashMessage('Událost vytvořena', 'success');
		$this->redirect('this');
	}

	public function actionDefault()
	{
		$this->myEvents();
		$this->otherEvents();

		$this->template->attendees = $this->attendeeRepository->getAttendees('5');
		//$this->template->approvals = $this->eventRepository->getApprovals($eventId);
	}




	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
/*
	public function handleApprove($approval, $id)
	{
		$this->context->attendeeRepository->setApproval($approval, $id);
		$this->redirect('default');
	}


	public function renderDefault()
	{
		$eventId = '3';
		$this->template->list = $this->list;
		$this->template->attendees = $this->context->attendeeRepository->getAttendees($eventId);
		$this->template->approvals = $this->context->eventRepository->getApprovals($eventId);

	}
*/
}