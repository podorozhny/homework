<?php

namespace Podorozhny\CoreBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Finder\Finder;

class CoreExtension
	extends Extension
{
	public function load(array $config, ContainerBuilder $container)
	{
		$yamlPath = __DIR__ . '/../Resources/config/services';
		$finder   = new Finder();
		$config   = $this->processConfiguration(new Configuration, $config);
		$loader   = new YamlFileLoader($container, new FileLocator($yamlPath));
		foreach (
			$finder->files()
				->name('*.yml')
				->in($yamlPath) as $file
		) {
			$loader->load($file->getRealpath());
		}
	}
}