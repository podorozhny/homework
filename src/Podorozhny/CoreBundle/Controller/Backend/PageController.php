<?php

namespace Podorozhny\CoreBundle\Controller\Backend;

use Podorozhny\CoreBundle\Controller\AbstractController;
use Podorozhny\Util\ChartsProviderInterface;

class PageController
	extends AbstractController
{
	protected $chartsProdiver;

	public function __construct(ChartsProviderInterface $chartsProvider)
	{
		$this->chartsProdiver = $chartsProvider;
	}

	public function homeAction()
	{
		$chartsData = $this->chartsProdiver->getData();
		$chartsData = json_encode($chartsData, JSON_UNESCAPED_UNICODE);

		return $this->render(
			'CoreBundle:Backend/Page:home.html.twig',
			['chartsData' => $chartsData]
		);
	}
}