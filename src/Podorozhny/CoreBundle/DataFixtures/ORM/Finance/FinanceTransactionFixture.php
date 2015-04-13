<?php

namespace Podorozhny\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Podorozhny\CoreBundle\DataFixtures\DataFixture;

class FinanceTransactionFixture
	extends DataFixture
{
	public function load(ObjectManager $manager)
	{
		$count = $this->faker->numberBetween(150, 200);

		$timestamps = $this->getTimeStamps($count, -3500000, 0);

		for ($i = 0; $i < $count; $i++) {
			$amount =
				$this->faker->boolean(80) ?
					$this->faker->numberBetween(1, 500) * 100
					: $this->faker->numberBetween(50, 500) * 1000;

			if ($this->faker->boolean(50)) {
				$amount = -$amount;
			}

			$this->createTransaction(
				array_shift($timestamps),
				$this->faker->realText($this->faker->numberBetween(10, 64)),
				$this->faker->boolean(30) ? $this->faker->realText(
					$this->faker->numberBetween(32, 4096)
				) : null,
				$amount
			);
		}
	}

	protected function createTransaction(
		$timestamp,
		$title,
		$description,
		$amount
	) {
		$createdAt = \DateTime::createFromFormat('U', $timestamp);

		$transactionManager =
			$this->get('podorozhny.manager.finance_transaction');
		$transaction        =
			$transactionManager->create()
				->setCreatedAt($createdAt)
				->setTitle($title)
				->setDescription($description)
				->setAmount($amount);

		$transactionManager->update($transaction);
	}

	public function getOrder()
	{
		return 30;
	}
}