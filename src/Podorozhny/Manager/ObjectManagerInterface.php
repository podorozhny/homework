<?php

namespace Podorozhny\Manager;

interface ObjectManagerInterface
{
	public function getEntityManager();

	public function getEventDispatcher();

	public function getClass();

	public function getRepository();

	public function create();

	public function update($entity, $andFlush);

	public function delete($entity);

	public function findOneBy(array $criteria);

	public function findById($id);

	public function findManyBy(array $criteria);

	public function findAll();
}