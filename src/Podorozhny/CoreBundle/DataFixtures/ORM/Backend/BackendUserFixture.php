<?php

namespace Podorozhny\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Podorozhny\CoreBundle\DataFixtures\DataFixture;

class BackendUserFixture
	extends DataFixture
{
	public function load(ObjectManager $manager)
	{
		$this->createUser(
			$this->getTimeStamps(1, -16156800, -15552000),
			'miller@homework.podorozhny.ru',
			'doshiraklapshichka',
			'Совет директоров',
			'Миллер Алексей Борисович'
		);

		$count = $this->faker->numberBetween(80, 100);
		
		$timestamps = $this->getTimeStamps($count, -15552000, 0);
		$emails     = $this->getEmails($count);

		for (
			$i = 0; $i < $count; $i++
		) {
			$groupNames = [
				'Отдел кадров',
				'Финансовый отдел',
				'Складской отдел',
				'Отдел по работе с клиентами',
			];

			$this->createUser(
				array_shift($timestamps),
				array_shift($emails),
				$this->faker->password,
				$groupNames[array_rand($groupNames)],
				$this->faker->name
			);
		}
	}

	protected function createUser(
		$timestamp,
		$email,
		$password,
		$groupName,
		$name
	) {
		$createdAt = \DateTime::createFromFormat('U', $timestamp);

		$userManager = $this->get('podorozhny.manager.backend_user');
		$user        =
			$userManager->create()
				->setCreatedAt($createdAt)
				->setEmail($email)
				->setPlainPassword($password)
				->setGroup(
					$this->getReference(
						'Podorozhny.Backend.Group.' . $groupName
					)
				)
				->setName($name);
		$userManager->update($user);
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

	public function getOrder()
	{
		return 12;
	}
}