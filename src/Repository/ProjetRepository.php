<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    /**
     * Search projects by title and filter by status using QueryBuilder with pagination.
     */
    public function findBySearchAndFilter(
        ?string $search = null,
        ?string $statut = null,
        ?string $sort = 'dateDebut',
        ?string $order = 'DESC',
        int $page = 1,
        int $limit = 5,
    ): Paginator {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.enseignant', 'e')
            ->addSelect('e')
            ->leftJoin('p.etudiants', 'et')
            ->addSelect('et');

        if ($search) {
            $qb->andWhere('p.titre LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($statut) {
            $qb->andWhere('p.statut = :statut')
                ->setParameter('statut', $statut);
        }

        $allowedSorts = ['dateDebut', 'dateFin', 'titre'];
        $sortField = in_array($sort, $allowedSorts) ? $sort : 'dateDebut';
        $sortOrder = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $qb->orderBy('p.' . $sortField, $sortOrder)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($qb, fetchJoinCollection: true);
    }

    /**
     * Count projects by status.
     *
     * @return array<string, int>
     */
    public function countByStatut(): array
    {
        $results = $this->createQueryBuilder('p')
            ->select('p.statut, COUNT(p.id) as total')
            ->groupBy('p.statut')
            ->getQuery()
            ->getResult();

        $counts = [];
        foreach ($results as $row) {
            $counts[$row['statut']] = (int) $row['total'];
        }
        return $counts;
    }
}
