<?php

use Nette\Application\UI,
    Nette\Application\UI\Form as Form,
    Nette\Mail\Message;
    


/**
 * Sign up/in/out presenters.
 */
class SignPresenter extends BasePresenter
{
   /** @var userRepository */
    private $userRepository;

    protected function startup() {
      parent::startup();
      
      if ($this->getUser()->isLoggedIn()) {
        $this->redirect('Homepage:');
      }
      
      $this->userRepository = $this->context->userRepository;
    }

    protected function createComponentSignUpForm() {
      $form = new Form;
      $form->addText('first_name', 'Křestní jméno', 25)
              ->addRule(Form::FILLED, 'Vyplňte Vaše křestní jméno')
              ->addCondition(Form::FILLED);
      $form->addText('last_name', 'Příjmení', 25)
              ->addRule(Form::FILLED, 'Vyplňte Vaše příjmení')
              ->addCondition(Form::FILLED);
      $form->addSelect('gender', 'Pohlaví:', array('male' => 'Muž', 'female' => 'Žena'))
              ->addRule(Form::FILLED, 'Zadejte Vaše pohlaví')
              ->addCondition(Form::FILLED);
      $form->addText('email', 'E-mail:', 35)
              ->addRule(Form::FILLED, 'Vyplňte Váš email')
              ->addRule(function($control) {
                  if($this->userRepository->findUser(array('email'=>$control->getValue()))){return false;}
                  else{return true;}
              }, "Duplicitní email")
              ->addCondition(Form::FILLED)
              ->addRule(Form::EMAIL, 'Neplatná emailová adresa');
      $form->addPassword('password', 'Heslo:', 20)
              ->setOption('description', 'Alespoň 6 znaků')
              ->addRule(Form::FILLED, 'Vyplňte Vaše heslo')
              ->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 6);
      $form->addPassword('password2', 'Zopakovat heslo:', 20)
              ->addConditionOn($form['password'], Form::VALID)
              ->addRule(Form::FILLED, 'Heslo znovu')
              ->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password']);
      $form->addSubmit('send', 'Registrovat');
      
      $form->onSuccess[] = $this->signUpFormSubmitted;
      return $form;
    }
    
    public function signUpFormSubmitted(UI\Form $form) {
      $values = $form->getValues();
      $new_user_id = $this->userRepository->registerUserDB($values);
      if($new_user_id){
        /*
        $mail = new Message;
        $mail->setFrom('Franta <franta@example.com>')
            ->addTo('petr@example.com')
            ->addTo('jirka@example.com')
            ->setSubject('Potvrzení objednávky')
            ->setBody("Dobrý den,\nvaše objednávka byla přijata.")
            ->send($mail);
        */
        
        $this->flashMessage('Registrace se povedla! Zkontrolujte si email.');
        $this->redirect('Sign:in');
      }
    }

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Zadejte Váš email.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte Vaše heslo.');

		$form->addCheckbox('remember', 'Zůstat přihlášen');

		$form->addSubmit('send', 'Přihládit se');

		$form->onSuccess[] = $this->signInFormSubmitted;
		return $form;
	}


	public function signInFormSubmitted($form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('+30 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->email, $values->password);
      $this->flashMessage('Přihlášení bylo úspěšné.', 'success');
			$this->redirect('Homepage:');

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}


	public function actionIn()
  {
    // facebook
    $fbUrl = $this->context->facebook->getLoginUrl(array(
      'scope' => 'email',
      'redirect_uri' => $this->link('//fbLogin'),
    ));
    
    $this->template->fbUrl = $fbUrl;
  }

  public function actionFbLogin()
  {
    $me = $this->context->facebook->api('/me');
    $identity = $this->context->facebookAuthenticator->authenticate($me);

    $this->getUser()->login($identity);
    $this->redirect('Homepage:');
  }

/*  protected function createComponentSignInForm()
  {
          $form = new Form;
          $form->addText('mail', 'Mail')
                  ->setRequired('Vyplňte e-mail.');

          $form->addPassword('password', 'Heslo')
                  ->setRequired('Vyplňte heslo');

          $form->addSubmit('s', 'Přihlásit se');

          $form->onSuccess[] = callback($this, 'signInFormSubmitted');
          return $form;
  }  */

/*  public function signInFormSubmitted($form)
  {
          try {
                  $values = $form->getValues();
                  $user = $this->getUser();
                  $user->login($values->mail, $values->password);
                  $this->redirect('Homepage:');

          } catch (\Nette\Security\AuthenticationException $e) {
                  $form->addError($e->getMessage());
          }
  } */

  public function handleSignOut()
  {
    $this->getUser()->logout();
    $this->flashMessage('Uživatel byl odhlášen.');
    $this->redirect('Homepage:');
  }

}
