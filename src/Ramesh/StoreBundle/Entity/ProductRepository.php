<?php

namespace Ramesh\StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
	public function findJoinedToCategory()
	{
		$query = $this->getEntityManager()
			->createQuery('
				SELECT p, c FROM RameshStoreBundle:Product p
				JOIN p.category c
				ORDER BY c.name ASC
				'
			);

		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	}
}
