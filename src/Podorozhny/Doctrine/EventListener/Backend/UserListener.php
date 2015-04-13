<?php

namespace Podorozhny\Doctrine\EventListener\Backend;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Podorozhny\Model\Backend\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserListener
	implements EventSubscriber
{
	protected $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function getSubscribedEvents()
	{
		return [Events::prePersist, Events::preUpdate,];
	}

	public function prePersist($args)
	{
		$user = $args->getEntity();

		if ($user instanceof UserInterface) {
			$this->updateUserFields($user);
		}
	}

	public function preUpdate($args)
	{
		$user = $args->getEntity();

		if ($user instanceof UserInterface) {
			$this->updateUserFields($user);

//            We are doing a update, so we must force Doctrine to update the changeset in case we changed something above
			$em   = $args->getEntityManager();
			$uow  = $em->getUnitOfWork();
			$meta = $em->getClassMetadata(get_class($user));
			$uow->recomputeSingleEntityChangeSet($meta, $user);
		}
	}

	protected function updateUserFields(UserInterface $user)
	{
		$userManager = $this->container->get('podorozhny.manager.backend_user');
		$userManager->updateCanonicalFields($user);
		$userManager->updatePassword($user);
	}
}