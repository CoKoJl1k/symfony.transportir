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
 * @extends ServiceEntityRepository<Comments>
 *
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    public function save(Comments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Claims[] Returns an array of Claims objects
     * @throws \Doctrine\ORM\NonUniqueResultException
     */

    public function getCommentsUsersByClaimId(int $ClaimId): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.text, c.files, c.created_at, c.updated_at, u.name as user_name')
            ->leftJoin(Users::class, 'u', Join::WITH, 'c.user_id = u.id')
            ->where('c.claims_id = :id')
            ->setParameter('id', $ClaimId)
            ->getQuery()
            ->getScalarResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCommentUserById(int $id): array
    {
        return  $this->createQueryBuilder('c')
            ->select('c.id, c.text, c.files, c.claims_id, c.created_at, c.updated_at, u.name as user_name')
            ->leftJoin(Users::class, 'u', Join::WITH, 'c.user_id = u.id')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }


//    /**
//     * @return Comments[] Returns an array of Comments objects
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

//    public function findOneBySomeField($value): ?Comments
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
