<?php

use Nette\Application\UI;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new UI\Form;
		$form->addText('email', 'Email:')
			->setRequired('Zadejte Váš email.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte Vaše heslo.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = $this->signInFormSucceeded;
		return $form;
	}


	public function signInFormSucceeded($form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->email, $values->password);
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

  public function actionOut()
  {
          $this->getUser()->logout();
          $this->flashMessage('Uživatel byl odhlášen.');
          $this->redirect('Homepage:');
  }

}
