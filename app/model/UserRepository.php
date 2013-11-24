<?php

/**
* User class
*/
class UserRepository extends Repository
{
	/**
	 * Creates new user
	 * @param string $first_name
	 * @param string $last_name
	 * @param string $password      
	 * @param string $email
	 * @param string $gender
	 * @return Nette\Database\Table\ActiveRow
	 * @author Šimon Appelt
	 */
	public function register($data)
	{
		return $this->getTable()->insert(array(
      'first_name' => $data->first_name,
      'last_name' => $data->last_name,
      'password' => Authenticator::calculateHash($data->password),
      'email' => $data->email,
			'date' => new \DateTime(),
      'gender' => $data->gender,
		));
	}
  
  public function existUserEmail($email)
	{
		$result = $this->getTable()->where("email", $email)->count("*");
    return $result;
	}
}