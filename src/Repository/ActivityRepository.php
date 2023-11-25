<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activity>
 *
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    // Méthode pour compter le nombre total d'activités pour un utilisateur
    public function countActivitiesForUser($user)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.author = :user')
            ->setParameter('user', $user)
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Méthode pour calculer la distance totale parcourue par un utilisateur
    public function sumDistanceForUser($user)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.author = :user')
            ->setParameter('user', $user)
            ->select('sum(a.distance)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Méthode pour calculer le total des calories brûlées par un utilisateur
    public function sumCaloriesForUser($user)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.author = :user')
            ->setParameter('user', $user)
            ->select('sum(a.calories)')
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return Activity[] Returns an array of Activity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Activity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
