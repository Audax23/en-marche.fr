<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ReferentTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReferentTagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReferentTag::class);
    }

    public function findByCodes(array $codes): array
    {
        return $this->findBy(['code' => $codes]);
    }
}