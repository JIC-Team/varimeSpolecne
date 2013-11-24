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
    $user = $this->userRepository->findUser(array('mail' => $fbUser['email']));

    if ($user) {
        $this->updateMissingData($user, $fbUser);
    } else {
        $user = $this->register($fbUser);
    }

    return $this->userRepository->createIdentity($user);
  }

  public function register(array $me)
  {
    $this->userRepository->registerUser(array(
      'email' => $me['email'],
      'fbid' => $me['id'],
      'first_name' => $me['name'],
    ));
  }

  public function updateMissingData($user, array $me)
  {
    $updateData = array();

    if (empty($user['first_name'])) {
      $updateData['first_name'] = $me['name'];
    }

    if (empty($user['fbid'])) {
      $updateData['fbid'] = $me['id'];
    }

    if (!empty($updateData)) {
      $this->userRepository->updateUser($user, $updateData);
    }
  }
}