<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FilmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }
}
