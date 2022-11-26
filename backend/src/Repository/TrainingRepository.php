<?php

namespace App\Repository;

use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Training>
 *
 * @method Training|null find($id, $lockMode = null, $lockVersion = null)
 * @method Training|null findOneBy(array $criteria, array $orderBy = null)
 * @method Training[]    findAll()
 * @method Training[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Training::class);
    }

    public function add(Training $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Training $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *  return all the training which are created by a coach
     * 
     * @return Training[] Returns an array of Training objects
     */
    public function findAllWhereCollaborationExists(int $coach_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select distinct training.id
        from training
        where triathlete_id in (select triathlete_id
        from collaboration where coach_id = :coach_id)';
        
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['coach_id' => $coach_id]);

        
        return $resultSet->fetchAllAssociative();
    }
       
    /**
     *  return the 3 last trainings added to the database
     * 
     * @return Training[] Returns an array of Training objects for back_office
     */
    public function find3LastTrainingBackOffice(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
}
