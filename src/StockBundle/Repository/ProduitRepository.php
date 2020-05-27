<?php

namespace StockBundle\Repository;

use EntrepotBundle\Entity\Entrepot;
use StockBundle\Entity\Produit;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function updatePrix(Produit $produit)
    {
        if ($produit->getQuantite()<20)
        {
            $fk=$produit->getIdProduit();
            return $this->createQueryBuilder('p')
                ->update('StockBundle:produit','p')
                ->set('p.prix', 'p.prix * 0.9')
                ->set('p.promotion', 'true')
                ->where('p.idProduit = ?0')
                ->setParameter(0,$fk)
                ->getQuery()
                ->execute();
        }

    }

}
