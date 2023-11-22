<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\WorkoutPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<WorkoutPlan>
 *
 * @method WorkoutPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkoutPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkoutPlan[]    findAll()
 * @method WorkoutPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutPlan::class);
    }

//    /**
//     * @return WorkoutPlan[] Returns an array of WorkoutPlan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkoutPlan
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.author = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

}
