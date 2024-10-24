<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Word>
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    //    /**
    //     * @return Word[] Returns an array of Word objects
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

        public function findOneRandom(): ?Word
        {
            $count = $this->createQueryBuilder('w')
                ->select($this->createQueryBuilder('w')->expr()->count('w.uuid'))
                ->getQuery()
                ->getSingleScalarResult();

            return $this->createQueryBuilder('w')
                ->select()
                ->setFirstResult(rand(1, $count))
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        }
}
