<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat", indexes={@ORM\Index(name="fk_entre", columns={"FK_id_entrepot"}),@ORM\Index(name="id_useer", columns={"FK_id_user"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\ContratRepository")
 */
class Contrat
{   /**
 * @var \DateTime
 *
 * @ORM\Column(name="date_deb", type="date", nullable=false)
 */
    private $datedeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $datefin;


    /**
     * @var \Entrepot
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="GererEntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot")
     * })

     */
    private $FKidentrepotr;

    /**
     * @var \Utilisateur
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_user", referencedColumnName="id_user")
     * })

     */
    private $FKiduser;


}

