<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
  public function handleSignOut()
  {
    $this->getUser()->logout();
    $this->flashMessage('Uživatel byl odhlášen.');
    $this->redirect('Homepage:');
  }

  public function beforeRender()
  {
  	$this->context->eventRepository->expireEvents();
  }
}
