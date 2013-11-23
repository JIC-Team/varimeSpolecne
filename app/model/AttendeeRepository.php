<?php

use Nette;

/**
* Handles atendees
*/
class AttendeeRepository extends Repository
{
	/**
	 *
	 * @return 
	 * @author David Pohan
	 */
	public function attend($userId, $eventId)
	{

		return $this->getTable()->insert(array(
			'user_id' => $userId,
			'event_id' => $eventId,
		));
	}
}