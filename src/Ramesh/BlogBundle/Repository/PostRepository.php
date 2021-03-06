<?php

namespace Ramesh\BlogBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends DocumentRepository
{
	public function getNPosts($n) {
		$query = $this->createQueryBuilder('p')
			->sort('p.createdAt', 'desc')
			->limit($n)
			->getQuery();		
		return $query->execute();
	}
}
