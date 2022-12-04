<?php

namespace App\Repository;

use App\Entity\CongressusUserInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CongressusUserInformation>
 *
 * @method CongressusUserInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CongressusUserInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CongressusUserInformation[]    findAll()
 * @method CongressusUserInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongressusUserInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CongressusUserInformation::class);
    }

    public function save(CongressusUserInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CongressusUserInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $value
     * @return CongressusUserInformation|null
     * @throws NonUniqueResultException
     */
    public function findOneByCongressusUserId($value): ?CongressusUserInformation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.congressus_user_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    public function findOneBySomeField($value): ?CongressusUserInformation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
