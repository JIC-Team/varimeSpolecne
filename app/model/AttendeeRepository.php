<?php

/**
 * Handles attendees
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
	public function addAttendee($userId, $eventId)
	{
		return $this->getTable()->insert(array(
			'user_id' => $userId,
			'event_id' => $eventId,
		));
	}

	public function find($by)
	{
		return $this->findBy($by);
	}

	/**
	 * returns attendees attending event with $eventId
	 * @param int $eventId
	 * @return Nette\Database\Table\Selection
	 * @author David Pohan
	 */
	public function getAttendees($eventId)
	{
		$attendees = array();
		foreach($this->getTable()->where(array('event_id' => $eventId)) as $attendee) 
		{
			$attendees[] = $attendee->ref('user');
		}
		//die(dump($attendees));
		return $attendees;
	}

	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function setApproval($id, $approval)
	{
		return $this->getDb()->exec('UPDATE attendee SET approved = ? WHERE id = ?', $approval, $id);
	}

	public function isAttending($userId)
	{
		
	}
}