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


	public function inject(AttendeeRepository $attendeeRepository)
	{
		parent::startup();
	}

	public function actionDefault($id)
	{
		$this->list = $this->context->eventRepository->findBy(array('id' => $id))->fetch();
		// if($this->list === FALSE)
		// 	$this->setView('Homepage:default');
	}

	/**
	 * @todo hardcoded eventId
	 */
	public function renderDefault()
	{
		$eventId = '3';
		$this->template->list = $this->list;
		$this->template->attendees = $this->context->attendeeRepository->getAttendees($eventId);
		$this->template->users = $this->context->userRepository->findAll();
	}

	public function createComponentEventForm()
	{
		$form = new Form();
		$form->addText('place', 'Místo:');
		$form->addText('maxPeople', 'Maximální počet lidí:');
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