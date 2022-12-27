<?php

namespace App\Repository;

use App\Entity\Petition;
use App\Entity\Signature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Petition>
 *
 * @method Petition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Petition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Petition[]    findAll()
 * @method Petition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Petition::class);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(int $id): Petition
    {
        $entity = $this->find($id);

        if (!$entity instanceof Petition) {
            throw new EntityNotFoundException("Petition was not fount [$id]");
        }

        return $entity;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getSignatureCount(Petition $petition)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(s.id)')
            ->join('p.signatures', 's')
            ->where('p = :petition')
            ->setParameter('petition', $petition);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function save(Petition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Petition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
