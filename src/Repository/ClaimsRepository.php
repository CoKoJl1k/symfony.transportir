<?php

namespace App\Repository;

use App\Entity\Claims;
use App\Entity\Comments;

use App\Entity\Status;
use App\Entity\Users;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Claims>
 *
 * @method Claims|null find($id, $lockMode = null, $lockVersion = null)
 * @method Claims|null findOneBy(array $criteria, array $orderBy = null)
 * @method Claims[]    findAll()
 * @method Claims[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Claims::class);
    }

    public function save(Claims $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Claims $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Claims[] Returns an array of Claims objects
     */

    public function getAllData(int $offset = 0, int $limit = 100): array
    {

        return  $this->createQueryBuilder('c')
            ->select('c.id, c.text, c.files, c.created_at, c.updated_at, u.name as u_name, s.name as status')
            ->leftJoin(Users::class, 'u', Join::WITH, 'c.user_id = u.id')
            ->leftJoin(Status::class, 's', Join::WITH, 'c.status_id = s.id')
            //   ->where('s.active = :active')
            //   ->setParameter('active', 1)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getScalarResult();
    }


//    /**
//     * @return Claims[] Returns an array of Claims objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Claims
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
