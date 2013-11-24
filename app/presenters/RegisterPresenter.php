<?php

use Nette\Application\UI,
    Nette\Application\UI\Form as Form;


class RegisterPresenter extends BasePresenter {

    /** @var userRepository */
    private $userRepository;

    protected function startup() {
        parent::startup();
        $this->userRepository = $this->context->userRepository;
    }

    public function renderRegister(){
    }


    protected function createComponentRegisterForm() {
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
                    if(($this->userRepository->existUserEmail($control->getValue()))>0){return false;}
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
        $form->onSuccess[] = callback($this, 'registerFormSubmitted');
        return $form;
    }
    
    public function registerFormSubmitted(UI\Form $form) {
        $values = $form->getValues();
        $new_user_id = $this->userRepository->register($values);
        if($new_user_id){
            $this->flashMessage('Registrace se povedla!');
            $this->redirect('Sign:in');
        }
    }
}