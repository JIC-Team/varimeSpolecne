<?php

/**
* Event repository
*/
class EventRepository extends Repository
{
	public function findEvent(array $by)
	{
		$event = $this->getTable()->where($by);
		$user = $this->connection->table('user')->where("id", $event->get('user_id'))->fetch();

		return $event;
	}

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