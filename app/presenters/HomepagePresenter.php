<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends UserPresenter
{
	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	
}
