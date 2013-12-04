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

  public function find(array $by)
   {
     return $this->findBy($by);
   } 
  
  public function registerUserDB($values)
  {
    return $this->getTable()->insert(array(
      'first_name' => $values->first_name,
      'last_name' => $values->last_name,
      'password' => Authenticator::calculateHash($values->password),
      'email' => $values->email,
			'date' => new \DateTime(),
      'gender' => $values->gender
  	));
  }
  
  public function registerUser(array $values)
  {
    $this->getTable()->insert($values);
  }
  
  public function updateUser(ActiveRow $user, array $values)
  {
    $user->update($values);
  }
  
  public function createIdentity(ActiveRow $user)
  {
    $data = $user->toArray();
    unset($user['password']);

    return new \Nette\Security\Identity($user->id, NULL, $data);
  }

  public function setPassword($id, $password)
  {
    $this->getTable()->where(array('id' => $id))->update(array(
        'password' => Authenticator::calculateHash($password)
    ));
  }
}