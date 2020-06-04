<?php

namespace GererEntrepotBundle\Repository;

/**
 * LocationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LocationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
 * @param string $titre
 *
 * @return array
 */
    public function findLike($fkUser)
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.fkUSer LIKE :fkUser')
            ->setParameter( 'fkUser', "%$fkUser%")
            ->orderBy('a.fkUser')
            ->setMaxResults(10)
            ->getQuery()
            ->execute()
            ;
    }
}
