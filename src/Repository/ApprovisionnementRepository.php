<?php

namespace App\Repository;

use App\Entity\Approvisionnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @extends ServiceEntityRepository<Approvisionnement>
 */
class ApprovisionnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Approvisionnement::class);
    }

    //    /**
    //     * @return Approvisionnement[] Returns an array of Approvisionnement objects
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

    //    public function findOneBySomeField($value): ?Approvisionnement
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Retourne la liste des fournisseurs ayant des approvisionnements
     */
    public function findFournisseurs(): array
    {
    $results = $this->createQueryBuilder('a')
        ->select('a', 'f')
        ->join('a.fournisseur', 'f')
        ->orderBy('f.nom', 'ASC')
        ->getQuery()
        ->getResult();

    $fournisseurs = [];

    foreach ($results as $appro) {
        $fournisseur = $appro->getFournisseur();
        $fournisseurs[$fournisseur->getId()] = $fournisseur;
    }

    return array_values($fournisseurs);
    }

    public function save(Approvisionnement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Retourne le montant total des approvisionnements
     */
    public function findTotalMontant(): float
    {
        return (float) $this->createQueryBuilder('a')
            ->select('SUM(a.total)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a','ar')
            ->join('a.articles', 'ar')
            ->orderBy('ar.libelle', 'ASC')
            ->getQuery()
            ->getResult();
    }

   

}


