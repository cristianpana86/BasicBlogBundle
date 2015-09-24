<?php
namespace CPANA\BasicBlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * BlogRepository
 *
 */
class BlogRepository extends EntityRepository
{
       /**
	    * Get all blog posts without paginator
		*
		* @return object
		*/
		public function getBlogs($limit = null)
		{
			$qb = $this->createQueryBuilder('b')
                   ->select('b')
                   ->addOrderBy('b.created', 'DESC');

			if (false === is_null($limit))
				$qb->setMaxResults($limit);

			return $qb->getQuery()
                  ->getResult();
		}
		/**
		 * Our new getAllPosts() method
		 *
		 * 1. Create & pass query to paginate method
		 * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
		 * 3. Return that object to the controller
		 *
		 * @param integer $currentPage The current page (passed from controller)
		 * 
		 * @return \Doctrine\ORM\Tools\Pagination\Paginator
		 *
		 * source: http://anil.io/post/41/symfony-2-and-doctrine-pagination-with-twig
		 */
		public function getAllPosts($currentPage = 1)
		{
			// Create our query
			$query = $this->createQueryBuilder('p')
				->orderBy('p.created', 'DESC')
				->getQuery();

			$paginator = $this->paginate($query, $currentPage);

			return $paginator;
		}

		/**
		 * Paginator Helper
		 *
		 * Pass through a query object, current page & limit
		 * the offset is calculated from the page and limit
		 * returns an `Paginator` instance, which you can call the following on:
		 *
		 *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
		 *     $paginator->count() # Count of ALL posts (ie: `20` posts)
		 *     $paginator->getIterator() # ArrayIterator
		 *
		 * @param Doctrine\ORM\Query $dql   DQL Query Object
		 * @param integer            $page  Current page (defaults to 1)
		 * @param integer            $limit The total number per page (defaults to 5)
		 *
		 * @return \Doctrine\ORM\Tools\Pagination\Paginator
		 *
		 * source: http://anil.io/post/41/symfony-2-and-doctrine-pagination-with-twig
		 */
		public function paginate($dql, $page = 1, $limit = 3)
		{
			$paginator = new Paginator($dql);
			
			$paginator->getQuery()
				->setFirstResult($limit * ($page - 1)) // Offset
				->setMaxResults($limit); // Limit

			return $paginator;
		}
}
