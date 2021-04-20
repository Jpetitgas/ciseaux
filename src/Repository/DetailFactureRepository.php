<?php

namespace App\Repository;

use App\Entity\DetailFacture;
use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailFacture|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailFacture|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailFacture[]    findAll()
 * @method DetailFacture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailFactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailFacture::class);
    }

    // /**
    //  * @return DetailFacture[] Returns an array of DetailFacture objects
    //  */
    public function totalByPrestationByfacture(Facture $facture)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.facture = :facture')
            ->groupBy('d.typePrestation')
            ->innerJoin('d.typePrestation', 'Prestation')
            ->select('SUM(d.prix) as total, Prestation.typeDePrestation')
            ->setParameter('facture', $facture)
            ->getQuery()
            ->getResult()
        ;
    }

    public function totalByPrestationByMois()
    {
        $Year = date('Y');

        return $this->createQueryBuilder('d')
            ->groupBy('p.typeDePrestation, date')
            ->innerJoin('d.typePrestation', 'p')
            ->innerJoin('d.facture', 'f')
            ->where('SUBSTRING(f.date, 1,4)= ?1')
            ->setParameter(1, $Year)
            ->orderBy('date', 'ASC')
            ->select('SUBSTRING(f.date, 1, 7) as date, SUM(d.prix) as total, p.typeDePrestation, p.colors')
            ->getQuery()
            ->getResult()
        ;
    }

    public function month()
    {
        $Year = date('Y');

       return $this->createQueryBuilder('d')
            ->groupBy('date')
            ->innerJoin('d.facture', 'f')
            ->where('SUBSTRING(f.date, 1,4)= ?1')
            ->setParameter(1, $Year)
            ->orderBy('date', 'ASC')
            ->select('SUBSTRING(f.date, 1, 7) as date')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?DetailFacture
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
