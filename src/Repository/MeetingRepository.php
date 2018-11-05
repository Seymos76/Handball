<?php

namespace App\Repository;

use App\Entity\Meeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    public function findNextMeeting(string $date)
    {
        return $this->createQueryBuilder('m')
            ->where('m.meeting_date = :meeting_date')
            ->andWhere('m.validated = :validated')
            ->setParameter('meeting_date', $date)
            ->setParameter('validated', false)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLastMeeting(string $date)
    {
        return $this->createQueryBuilder('m')
            ->where('m.meeting_date = :meeting_date')
            ->andWhere('m.validated = :validated')
            ->setParameter('meeting_date', $date)
            ->setParameter('validated', true)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findValidatedMeetings()
    {
        return $this->createQueryBuilder('m')
            ->where('m.validated = :validated')
            ->setParameter('validated', true)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Meeting[] Returns an array of Meeting objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meeting
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
