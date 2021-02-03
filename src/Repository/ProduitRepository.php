<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Data\ProduitSearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return Produit[]
     */
    public function findSearch(ProduitSearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('p', 'pt')
            ->join('p.produitType', 'pt');

        if(!empty($search->produitTypes)) {
            $query = $query
                ->andWhere('pt.id IN (:produitTypes)')
                ->setParameter('produitTypes', $search->produitTypes);
        }

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.nom LIKE :q')
                ->orWhere('p.description LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->min)) {
            $query = $query
                ->andWhere('p.prix >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('p.prix <= :max')
                ->setParameter('max', $search->max);
        }

        return $query->getQuery()->getResult();
    }

    public function findByMonth($type)
    {
        return $this->createQueryBuilder('p')
            ->select(' COUNT(p.nom) as count, MONTH(p.createdAt) AS month')
            ->groupBy('month')
            ->leftJoin('App\Entity\ProduitType', 'pt', Join::WITH, 'p.produitType = pt.id')
            ->where('pt.slug = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
