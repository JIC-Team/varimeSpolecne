<?php

// use Nette;

/**
* Event class
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
	public function createEvent($userId, $place, $food, $maxPeople, $title, $description)
	{
		/**
		 * @todo userID
		 */
		return $this->getTable()->insert(array(
			'date' => new \DateTime(),
			'place' => $place,
			'max_people' => $maxPeople,
			'food' => $food,
			'title' => $title,
			'description' => $description,
			'user_id' => $userId,
		));
	}

	/**
	 * Returns filtered rows, ex. array('place' => 'Jungmannova').
	 * @return Nette\Database\Table\Selection
	 * @author David Pohan
	 */
	public function find(array $by)
	{
		return $this->findBy($by);
	}

	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function approvePerson($userId, $approvePerson)
	{
		// return $this->getTable()->where(array('user_id' => $userId))->update('people' => 'people'+$add);
		if($approvePerson)
			return $this->getDb()->exec('UPDATE event SET people = people + 1 WHERE id = ?', $userId);
	}

	/**
	 * @author David Pohan
	 */
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