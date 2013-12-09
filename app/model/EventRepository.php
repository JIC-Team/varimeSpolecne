<?php

/**
* Event repository
*/
class EventRepository extends Repository
{
	public function updateEvent($eventId, Nette\Application\UI\Form $form)
	{
		return $this->find(array('id' => $eventId))->update(array(
			'date' => $form->values->date,
			'place' => $form->values->place,
			'max_people' => $form->values->max_people,
			'food' => $form->values->food,
			'title' => $form->values->title,
			'description' => $form->values->description,
		));
	}

	/**
	 * Returns filtered rows, ex. array('place' => 'Jungmannova').
	 * @return Nette\Database\Table\Selection
	 * @author David Pohan
	 */
	public function find(array $by)
	{
		$event = $this->getTable()->where($by);
		$user = $this->connection->table('user')->where("id", $event->get('user_id'))->fetch();

		return $event;
	}

	public function createEvent($userId, $form)
	{
		return $this->getTable()->insert(array(
			'date' => $form->values->date,
			'place' => $form->values->place,
			'max_people' => $form->values->max_people,
			'food' => $form->values->food,
			'title' => $form->values->title,
			'description' => $form->values->description,
			'expired' => 0,
			'user_id' => $userId,
		));
	}

	public function delete($id)
	{
		return $this->find(array('id' => $id))->delete();
	}

	public function expireEvents()
	{
		foreach($this->findAll() as $event)
			if($event->date <= new \DateTime() && !$event->expired)
				$this->expire($event->id, $event);
	}

	public function expire($eventId, $event)
	{
		return $event->update(array('expired' => '1'));
	}
}