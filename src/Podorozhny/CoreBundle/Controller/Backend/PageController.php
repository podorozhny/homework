<?php

namespace Podorozhny\CoreBundle\Controller\Backend;

use Podorozhny\CoreBundle\Controller\AbstractController;

class PageController
	extends AbstractController
{
	public function homeAction()
	{
		return $this->render('CoreBundle:Backend/Page:home.html.twig');
	}
}