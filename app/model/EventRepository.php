<?php

use Nette;

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
	public function addPerson($userId, $add)
	{
		return $this->getTable()->where(array('user_id' => $userId))->update('people' => 'people'+$add);
	}
}