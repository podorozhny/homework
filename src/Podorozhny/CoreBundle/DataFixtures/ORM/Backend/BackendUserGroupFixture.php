<?php

namespace Podorozhny\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Podorozhny\CoreBundle\DataFixtures\DataFixture;

class BackendUserGroupFixture
	extends DataFixture
{
	public function load(ObjectManager $manager)
	{
		$this->createGroup(
			'Совет директоров',
			['ROLE_PERSONNEL', 'ROLE_FINANCE', 'ROLE_WAREHOUSE', 'ROLE_CLIENTS']
		);
		$this->createGroup('Отдел кадров', ['ROLE_PERSONNEL']);
		$this->createGroup('Финансовый отдел', ['ROLE_FINANCE']);
		$this->createGroup('Складской отдел', ['ROLE_WAREHOUSE']);
		$this->createGroup('Отдел по работе с клиентами', ['ROLE_CLIENTS']);
	}

	protected function createGroup($name, $roles = [])
	{
		$groupManager = $this->get('podorozhny.manager.backend_user_group');

		$group =
			$groupManager->create()
				->setName($name);

		foreach ($roles as $role) {
			$group->addRole(
				$this->getReference(
					'Podorozhny.Backend.Role.' . $role
				)
			);
		}

		$this->setReference('Podorozhny.Backend.Group.' . $name, $group);

		$groupManager->update($group);
	}

	public function getOrder()
	{
		return 11;
	}
}