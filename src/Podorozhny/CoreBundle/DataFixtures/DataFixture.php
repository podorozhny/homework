<?php

namespace Podorozhny\CoreBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Provider\ru_RU\Text;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Factory as FakerFactory;

abstract class DataFixture
	extends AbstractFixture
	implements ContainerAwareInterface, OrderedFixtureInterface
{
	protected $container;
	protected $faker;

	public function __construct()
	{
		$this->faker = FakerFactory::create('ru_RU');
		$this->faker->addProvider(new Text($this->faker));
	}

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	protected function get($id)
	{
		return $this->container->get($id);
	}

	protected function getTimeStamps($count, $from, $to)
	{
		$currentTimestamp = (int) (new \DateTime)->format('U');

		$timestamps = [];

		for ($i = 0; $i < $count; $i++) {
			$timestamps[$i] =
				$currentTimestamp + $this->faker->numberBetween($from, $to);
		}

		asort($timestamps);

		return count($timestamps) == 1 ? $timestamps[0] : $timestamps;
	}
}