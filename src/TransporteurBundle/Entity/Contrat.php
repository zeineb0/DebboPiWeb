<?php

namespace TransprteurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat", indexes={@ORM\Index(name="fk_entre", columns={"FK_id_entrepot"}),@ORM\Index(name="id_useer", columns={"FK_id_user"})})
 * @ORM\Entity(repositoryClass="TransporteurBundle\Repository\ContratRepository")
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
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot")
     * })

     */
    private $FKidentrepotr;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_user", referencedColumnName="id_user")
     * })

     */
    private $FKiduser;

    /**
     * Contrat constructor.
     * @param \DateTime $datedeb
     * @param \DateTime $datefin
     * @param \Entrepot $FKidentrepotr
     * @param \User $FKiduser
     */
    public function __construct(\DateTime $datedeb, \DateTime $datefin, \Entrepot $FKidentrepotr, \User $FKiduser)
    {
        $this->datedeb = $datedeb;
        $this->datefin = $datefin;
        $this->FKidentrepotr = $FKidentrepotr;
        $this->FKiduser = $FKiduser;
    }


    /**
     * @return \DateTime
     */
    public function getDatedeb()
    {
        return $this->datedeb;
    }

    /**
     * @param \DateTime $datedeb
     */
    public function setDatedeb($datedeb)
    {
        $this->datedeb = $datedeb;
    }

    /**
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }

    /**
     * @return \Entrepot
     */
    public function getFKidentrepotr()
    {
        return $this->FKidentrepotr;
    }

    /**
     * @param \Entrepot $FKidentrepotr
     */
    public function setFKidentrepotr($FKidentrepotr)
    {
        $this->FKidentrepotr = $FKidentrepotr;
    }

    /**
     * @return \User
     */
    public function getFKiduser()
    {
        return $this->FKiduser;
    }

    /**
     * @param \User $FKiduser
     */
    public function setFKiduser($FKiduser)
    {
        $this->FKiduser = $FKiduser;
    }






}

