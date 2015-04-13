<?php

namespace Podorozhny\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class ObjectManager
	implements ObjectManagerInterface
{
	protected $entityManager;
	protected $eventDispatcher;
	protected $class;

	public function __construct(
		EntityManager $entityManager,
		EventDispatcherInterface $eventDispatcher,
		$class
	) {
		$this->entityManager   = $entityManager;
		$this->eventDispatcher = $eventDispatcher;
		$this->class           = $class;
	}

	public function getEntityManager()
	{
		return $this->entityManager;
	}

	public function getEventDispatcher()
	{
		return $this->eventDispatcher;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function getRepository()
	{
		return $this->getEntityManager()
			->getRepository($this->class);
	}

	public function create()
	{
		$class = $this->getClass();

		return new $class();
	}

	public function update($entity, $andFlush = true)
	{
		$this->getEntityManager()
			->persist($entity);
		if ($andFlush) {
			$this->getEntityManager()
				->flush();
		}
	}

	public function delete($entity)
	{
		$this->getEntityManager()
			->remove($entity);
		$this->getEntityManager()
			->flush();
	}

	public function findOneBy(array $criteria, array $orderBy = null)
	{
		return $this->getRepository()
			->findOneBy($criteria, $orderBy);
	}

	public function findById($id, array $orderBy = null)
	{
		return $this->findOneBy(['id' => $id], $orderBy);
	}

	public function findManyBy(
		array $criteria,
		array $orderBy = null,
		$limit = null,
		$offset = null
	) {
		return $this->getRepository()
			->findBy($criteria, $orderBy, $limit, $offset);
	}

	public function findAll(
		array $orderBy = null,
		$limit = null,
		$offset = null
	) {
		return $this->getRepository()
			->findAll($orderBy, $limit, $offset);
	}
}