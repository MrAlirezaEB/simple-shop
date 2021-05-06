<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $requestStack; // will be used for getting request data for pagination

    public function __construct(ManagerRegistry $registry , RequestStack $requestStack)
    {
        parent::__construct($registry, Product::class);
        $this->requestStack = $requestStack;
    }

    public function getAllProducts( $limit = 20 , $currentPage = 1 , $orderBy = 'createdAt' , $order = 'DESC')
    {
        // check request for valid data
        $request = $this->requestStack->getCurrentRequest();
        $currentPage = $request->query->get('page') ? : $currentPage; //check for page parameter
        $orderBy = $request->query->get('orderBy') ? : $orderBy;
        $order = $request->query->get('order') ? : $order;

        // creating query
        $query = $this->createQueryBuilder('p')
            ->orderBy("p.$orderBy", $order)
            ->getQuery();

        $paginator = $this->paginate($query, $currentPage , $limit);

        return $paginator;
    }

    private function paginate($dql, $page = 1, $limit)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // offset
            ->setMaxResults($limit); // limit
        // paginator meta data for making links
        $paginator->links = [
            'limit'=>$limit,
            'maxPages'=> ceil($paginator->count() / $limit),
            'currentPage' => $page
        ];
        return $paginator;
    }

    public function search($value)
    {
        $query =  $this->createQueryBuilder('p');
        $query->where($query->expr()->like('p.title', ':val'))
            ->setParameter('val', "%".$value."%")
            ->orderBy('p.id', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, 1 , 12);

        return $paginator;
    }



    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
