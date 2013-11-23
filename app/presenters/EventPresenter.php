<?php

use Nette\Application\UI\Form;

/**
* Event presenter
*/
class EventPresenter extends BasePresenter
{
	private $eventRepository;

	private $list;


	public function inject(EventRepository $eventRepository)
	{
		$this->eventRepository = $eventRepository;
	}

	public function actionDefault($id)
	{
		$this->list = $this->eventRepository->findBy(array('id' => $id))->fetch();
		if($this->list === FALSE)
			$this->setView('notFound');
	}

	public function renderDefault()
	{
		$this->template->list = $this->list;
	}

	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function createComponentTaskForm()
	{
		$form = new Form();
		$form->addText('place', 'Místo:');
		$form->addText('maxPeople', 'Maximální počet lidí:');
		$form->addText('food', 'Jídlo:');
		$form->addText('title', 'Název:');
		$form->addText('description', 'Popis:');
		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->taskFormSubmitted;

		return $form;
	}

	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function taskFormSubmitted(Form $form)
	{
		/**
		 * @todo userID
		 */
		$this->eventRepository->createEvent('0', $form->values->place, $form->values->food, $form->values->maxPeople, $form->values->title, $form->values->description);
		$this->flashMessage('Událost vytvořena');
		$this->redirect('this');
	}
}