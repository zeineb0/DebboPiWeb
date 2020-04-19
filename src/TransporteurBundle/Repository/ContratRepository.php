<?php

namespace TransporteurBundle\Repository;

/**
 * ContratRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContratRepository extends \Doctrine\ORM\EntityRepository
{

    public function getContratByProp($id)
    {
        $qb=$this->getEntityManager()
            ->createQuery("select e.idEntrepot , u.id , c.datedeb , c.datefin , c.salaire , u.nom , u.prenom , e.entreprise from TransporteurBundle:contrat c JOIN c.FKiduser u JOIN c.FKidentrepot e where c.FKidentrepot IN ( select t.idEntrepot from EntrepotBundle:entrepot t where t.idUser=?1) ")
            ->setParameters(array(1=>$id));
        return $query = $qb->getResult();
    }

  /*  public function updateContrat($dateDeb,$dateFin)
    {
        $qb=$this->getEntityManager()
            ->createQuery("Update TransporteurBundle:livraison l SET l.etatLivraison=?1 where l.idLivraison=?2")
            ->setParameters(array(1=>'livrée',2=>$id));
        return $query=$qb->getResult();
    }
*/

}