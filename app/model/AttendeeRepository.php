<?php

// use Nette;

/**
* Handles atendees
*/
class AttendeeRepository extends Repository
{
	/**
	 * Makes user want to attend event
	 * @param int $userId
	 * @param int $eventId
	 * @return Nette\Database\Table\ActiveRow
	 * @author David Pohan
	 */
	public function attend($userId, $eventId)
	{
		return $this->getTable()->insert(array(
			'user_id' => $userId,
			'event_id' => $eventId,
		));
	}

	/**
	 * returns attendees attending event with $eventId
	 * @param int $eventId
	 * @return Nette\Database\Table\Selection
	 * @author David Pohan
	 */
	public function getAttendees($eventId)
	{
		return $this->findBy(array('event_id' => $eventId));
	}	
}