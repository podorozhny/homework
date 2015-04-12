<?php

namespace Podorozhny\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Podorozhny\CoreBundle\DataFixtures\DataFixture;

class WarehouseGoodFixture
	extends DataFixture
{
	public function load(ObjectManager $manager)
	{
		$count = $this->faker->numberBetween(50, 80);

		$timestamps = $this->getTimeStamps($count, -3500000, 0);

		for ($i = 0; $i < $count; $i++) {
			$this->createGood(
				array_shift($timestamps),
				$this->faker->realText($this->faker->numberBetween(10, 64)),
				$this->faker->boolean(30) ? $this->faker->realText(
					$this->faker->numberBetween(32, 4096)
				) : null,
				$this->faker->numberBetween(0, 50),
				$this->faker->boolean(80) ?
					$this->faker->numberBetween(1, 99) * 10
					: $this->faker->numberBetween(10, 150) * 100
			);
		}
	}

	protected function createGood(
		$timestamp,
		$name,
		$description,
		$amount,
		$weight
	) {
		$createdAt = \DateTime::createFromFormat('U', $timestamp);

		$goodManager = $this->get('podorozhny.manager.warehouse_good');
		$good        =
			$goodManager->create()
				->setCreatedAt($createdAt)
				->setName($name)
				->setDescription($description)
				->setCount($amount)
				->setWeight($weight);

		$goodManager->update($good);
	}

	public function getOrder()
	{
		return 30;
	}
}