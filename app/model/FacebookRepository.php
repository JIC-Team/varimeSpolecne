<?php

class FacebookRepository
{
  /** @var UserRepository */
  private $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  /**
   * @param array $fbUser
   * @return \Nette\Security\Identity
   */
  public function authenticate(array $fbUser)
  {
    $user = $this->userRepository->findUser(array('email' => $fbUser['email']));

    if($user) {
      $this->updateMissingData($user, $fbUser);
    } else {
      $user = $this->register($fbUser);
      $user = $this->userRepository->findUser(array('email' => $fbUser['email']));
    }

    return $this->userRepository->createIdentity($user);
  }

  public function register(array $me)
  {
    $this->userRepository->registerUser(array(
      'fbid' => $me['id'],
      'date' => new \DateTime(),
      'email' => $me['email'],
      'password' => '',
      'first_name' => $me['first_name'],
      'last_name' => $me['last_name'],
      'gender' => $me['gender'],
      'access_token' => $me['access_token'],
    ));
  }

  public function updateMissingData($user, array $me)
  {
    $updateData = array();

    if (empty($user['fbid'])) {
      $updateData['fbid'] = $me['id'];
    }
    
    if (empty($user['access_token'])) {
      $updateData['access_token'] = $me['access_token'];
    }

    if (!empty($updateData)) {
      $this->userRepository->updateUser($user, $updateData);
    }
  }
}