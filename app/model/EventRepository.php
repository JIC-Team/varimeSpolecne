<?php

/**
* Event repository
*/
class EventRepository extends Repository
{
	/**
	 * Creates new event
	 * @param int $userId
	 * @param string $place
	 * @param string $food
	 * @param int $maxPeople
	 * @param string $title
	 * @param string $description
	 * @return Nette\Database\Table\ActiveRow
	 * @author David Pohan
	 */
	public function createEvent($userId, $dateTime, $place, $food, $maxPeople, $title, $description)
	{
		/**
		 * @todo userID
		 */
		return $this->getTable()->insert(array(
			'date' => $dateTime,
			'place' => $place,
			'max_people' => $maxPeople,
			'food' => $food,
			'title' => $title,
			'description' => $description,
			'user_id' => $userId,
		));
	}

	public function updateEvent($eventId, Nette\Application\UI\Form $form)
	{
		return $this->getDb()->exec('UPDATE event SET date = ?, place = ?, max_people = ?, food = ?, title = ?, description = ? WHERE id = ?', new \DateTime(), $form->values->place, $form->values->max_people, $form->values->food, $form->values->title, $form->values->description, $eventId);
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
/*
	public function createEvent($userId, $values)
	{
		return $this->getTable()->insert(array(
			'date' => $values->datetime,
			'place' => $values->place,
			'max_people' => $values->maxPeople,
			'food' => $values->food,
			'title' => $values->title,
			'description' => $values->description,
			'user_id' => $userId,
		));
	}
*/
	public function approvePerson($userId, $approvePerson)
	{
		// return $this->getTable()->where(array('user_id' => $userId))->update('people' => 'people'+$add);
		if($approvePerson)
			return $this->getDb()->exec('UPDATE event SET people = people + 1 WHERE id = ?', $userId);
	}

	public function getApprovals($eventId)
	{
		$approvals = array();
		foreach($this->getTable()->where(array('id' => $eventId)) as $approval)
		{
			$approvals[] = $approval->related('attendee');
		}
		return $approvals;
	}
}