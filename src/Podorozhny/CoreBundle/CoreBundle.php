<?php

namespace Podorozhny\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Podorozhny\CoreBundle\DependencyInjection\CoreExtension;

class CoreBundle
	extends Bundle
{
	public function getContainerExtension()
	{
		return new CoreExtension();
	}
}