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
		$names = array();
		foreach($this->getTable()->where(array('event_id' => $eventId)) as $attendee) 
		{
			$names = $attendee->ref('user');
		}
		return $names;
		// die(var_dump($names));
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