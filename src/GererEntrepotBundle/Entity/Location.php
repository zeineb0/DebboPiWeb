<?php

namespace GererEntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location", indexes={@ORM\Index(name="Location_Entrepot", columns={"FK_id_entrepot"}), @ORM\Index(name="Location_Utilisateur", columns={"FK_id_user"})})
 * @ORM\Entity(repositoryClass="GererEntrepotBundle\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_location", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLocation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb_location", type="date", nullable=false)
     */
    private $dateDebLocation;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_location", type="date", nullable=false)
     */
    private $dateFinLocation;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_location", type="float", precision=10, scale=10, nullable=false)
     */
    private $prixLocation;

    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEntrepot;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_user", referencedColumnName="id_user")
     * })
     */
    private $fkUser;




    /**
     * @return int
     */
    public function getIdLocation()
    {
        return $this->idLocation;
    }

    /**
     * @param int $idLocation
     */
    public function setIdLocation($idLocation)
    {
        $this->idLocation = $idLocation;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebLocation()
    {
        return $this->dateDebLocation;
    }

    /**
     * @param \DateTime $dateDebLocation
     */
    public function setDateDebLocation($dateDebLocation)
    {
        $this->dateDebLocation = $dateDebLocation;
    }

    /**
     * @return \DateTime
     */
    public function getDateFinLocation()
    {
        return $this->dateFinLocation;
    }

    /**
     * @param \DateTime $dateFinLocation
     */
    public function setDateFinLocation($dateFinLocation)
    {
        $this->dateFinLocation = $dateFinLocation;
    }

    /**
     * @return float
     */
    public function getPrixLocation()
    {
        return $this->prixLocation;
    }

    /**
     * @param float $prixLocation
     */
    public function setPrixLocation($prixLocation)
    {
        $this->prixLocation = $prixLocation;
    }

    /**
     * @return \Entrepot
     */
    public function getFkEntrepot()
    {
        return $this->fkEntrepot;
    }

    /**
     * @param \Entrepot $fkEntrepot
     */
    public function setFkEntrepot($fkEntrepot)
    {
        $this->fkEntrepot = $fkEntrepot;
    }

    /**
     * @return EntrepotBundle\Entity\Utilisateur
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }

    /**
     * @param EntrepotBundle\Entity\Utilisateur $fkUser
     */
    public function setFkUser($fkUser)
    {
        $this->fkUser = $fkUser;
    }



}