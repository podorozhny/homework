<?php

namespace Podorozhny\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Podorozhny\CoreBundle\DataFixtures\DataFixture;

class ClientsClientFixture
	extends DataFixture
{
	public function load(ObjectManager $manager)
	{
		$count = $this->faker->numberBetween(250, 300);

		$timestamps = $this->getTimeStamps($count, -15552000, 0);
		$emails     = $this->getEmails($count);
		$phones     = $this->getPhones($count);

		for ($i = 0; $i < $count; $i++) {
			$name = explode(' ', $this->faker->name);

			if ($this->faker->boolean(35)) {
				unset($name[1]);
				unset($name[2]);
			} elseif ($this->faker->boolean(35)) {
				unset($name[2]);
			}

			$name = implode(' ', $name);

			$this->createClient(
				array_shift($timestamps),
				$this->faker->boolean(85) ? $name : null,
				$this->faker->boolean(75) ? array_shift($emails) : null,
				$this->faker->boolean(85) ? array_shift($phones) : null,
				$this->faker->boolean(25) ? $this->faker->realText(
					$this->faker->numberBetween(10, 4096)
				) : null
			);
		}
	}

	protected function createClient(
		$timestamp,
		$name,
		$email,
		$phone,
		$notes
	) {
		$createdAt = \DateTime::createFromFormat('U', $timestamp);

		$clientManager = $this->get('podorozhny.manager.clients_client');
		$client        =
			$clientManager->create()
				->setCreatedAt($createdAt)
				->setName($name)
				->setEmail($email)
				->setPhone($phone)
				->setNotes($notes);

		$clientManager->update($client);
	}

	protected function getEmails($count)
	{
		$emails = [];

		while (count($emails) < $count) {
			$email = $this->faker->email;

			if (array_search($email, $emails) === false) {
				$emails[] = $email;
			}
		}

		return $emails;
	}

	protected function getPhones($count)
	{
		$phoneCodes = ['495', '499', '903', '915', '916', '925', '926', '968'];

		$phones = [];

		while (count($phones) < $count) {
			$phone =
				$phoneCodes[array_rand($phoneCodes)]
				. $this->faker->numberBetween(1000000, 9999999);

			if (array_search($phone, $phones) === false) {
				$phones[] = $phone;
			}
		}

		return $phones;
	}

	public function getOrder()
	{
		return 20;
	}
}