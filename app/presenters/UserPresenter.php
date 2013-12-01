<?php

use Nette\Application\UI\Form;
use Nette\Security as NS;


/**
 * User presenter.
 */
class UserPresenter extends BasePresenter
{
	/** @var Todo\UserRepository */
    private $userRepository;

    /** @var Todo\Authenticator */
    private $authenticator;


    protected function startup()
    {
        parent::startup();

        $this->userRepository = $this->context->userRepository;
        $this->authenticator = $this->context->authenticator;
    }


    protected function createComponentPasswordForm()
    {
    	$form = new Form();
    	
    	if(!$this->userRepository->findUser(array("email"=>$this->getUser()->getIdentity()->email, "password"=>"")))
    	{
    		$form->addPassword('oldPassword', 'Staré heslo:', 30)
            	->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
    	} else {
    		$form->addHidden('oldPassword');
    	}

        $form->addPassword('newPassword', 'Nové heslo:', 30)
            ->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
        $form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
            ->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
            ->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);
        $form->addSubmit('set', 'Změnit heslo');
        $form->onSuccess[] = $this->passwordFormSubmitted;
        return $form;
    }

    public function passwordFormSubmitted(Form $form)
    {
        $values = $form->getValues();
        $user = $this->getUser();
        try {
        	if($values->oldPassword!=null){
            	$this->authenticator->authenticate(array($user->getIdentity()->email, $values->oldPassword));
            }
            $this->userRepository->setPassword($user->getId(), $values->newPassword);
            $this->flashMessage('Heslo bylo změněno.', 'success');
            $this->redirect('Homepage:');
        } catch (NS\AuthenticationException $e) {
            $form->addError('Zadané heslo není správné.');
        }
    }
}
