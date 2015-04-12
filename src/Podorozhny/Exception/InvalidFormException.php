<?php

namespace Podorozhny\Exception;

class InvalidFormException
	extends \RuntimeException
{
	protected $form;

	public function __construct($message, $form = null)
	{
		$this->form = $form;

		parent::__construct($message);
	}

	public function getForm()
	{
		return $this->form;
	}
}