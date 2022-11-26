<?php

namespace App\Repository;

use App\Entity\Triathlete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Triathlete>
 *
 * @method Triathlete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Triathlete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Triathlete[]    findAll()
 * @method Triathlete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TriathleteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Triathlete::class);
    }

    public function add(Triathlete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Triathlete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * return the 3 last triathlete added to the database
     * 
     * @return Triathlete[] Returns an array of Triathlete objects for back_office
     */
    public function find3LastTriathleteBackOffice(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
}
