<?php

namespace Podorozhny\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository
	extends EntityRepository
{
	public function findAll(
		array $orderBy = null,
		$limit = null,
		$offset = null
	) {
		return $this->findBy([], $orderBy, $limit, $offset);
	}
}