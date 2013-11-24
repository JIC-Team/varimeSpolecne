<?php

use Nette\Database\Connection;
use Nette\Database\Table\ActiveRow;
use Nette\Security\Identity;

class UserRepository extends Repository
{    
  public function findUser(array $by)
  {
      return $this->getTable()->where($by)->fetch();
  }  
  
  public function registerUser($values)
  {
    return $this->getTable()->insert(array(
      'first_name' => $values->first_name,
      'last_name' => $values->last_name,
      'password' => Authenticator::calculateHash($values->password),
      'email' => $values->email,
			'date' => new \DateTime(),
      'gender' => $values->gender,
  	));
  }
  
  public function updateUser(ActiveRow $user, array $values)
  {
      $user->update($values);
  }
}