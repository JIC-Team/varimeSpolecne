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


	public function inject(EventRepository $eventRepository, AttendeeRepository $attendeeRepository)
	{
		parent::startup();
		$this->eventRepository = $eventRepository;
		$this->attendeeRepository = $attendeeRepository;
	}

	public function actionDefault($id)
	{
		$this->list = $this->eventRepository->findBy(array('id' => $id))->fetch();
		// if($this->list === FALSE)
		// 	$this->setView('Homepage:default');
	}

	public function renderDefault()
	{
		$this->template->list = $this->list;
		$this->template->attendees = $this->attendeeRepository->findAll();
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