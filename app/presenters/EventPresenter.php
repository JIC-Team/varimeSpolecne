<?php

use Nette\Application\UI\Form;

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
		// if(!$this->getUser()->isLoggedIn())
		// 	$this->redirect('Sign:in');
	}

	public function actionDefault($id)
	{
		$this->list = $this->context->eventRepository->findBy(array('id' => $id))->fetch();
		// if($this->list === FALSE)
		// 	$this->setView('Homepage:default');
	}

	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function handleApprove($approval, $id)
	{
		$this->context->attendeeRepository->setApproval($approval, $id);
		$this->redirect('default');
	}

	/**
	 * @todo hardcoded eventId
	 */
	public function renderDefault()
	{
		$eventId = '3';
		$this->template->list = $this->list;
		$this->template->attendees = $this->context->attendeeRepository->getAttendees($eventId);
		$this->template->approvals = $this->context->eventRepository->getApprovals($eventId);

	}

	public function createComponentEventForm()
	{
		$form = new Form();
		$form->addText('place', 'Místo:');
		$form->addText('maxPeople', 'Maximální počet lidí:')
		->addRule(Form::INTEGER);
		$form->addText('food', 'Jídlo:');
		$form->addText('title', 'Název:');
		$form->addText('description', 'Popis:');
		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->eventFormSubmitted;

		return $form;
	}

	public function eventFormSubmitted(Form $form)
	{
		/**
		 * @todo userID
		 */
		$this->eventRepository->createEvent('1', $form->values->place, $form->values->food, $form->values->maxPeople, $form->values->title, $form->values->description);
		$this->flashMessage('Událost vytvořena');
		$this->redirect('this');
	}
}