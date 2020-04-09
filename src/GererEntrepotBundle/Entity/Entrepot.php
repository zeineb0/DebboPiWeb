<?php

namespace GererEntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Entrepot
 *
 * @ORM\Table(name="entrepot", indexes={@ORM\Index(name="FK_id_user", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="GererEntrepotBundle\Repository\EntrepotRepository")
 */
class Entrepot
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_entrepot", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEntrepot;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=10, nullable=false)
     * @Assert\Length(min="3",max="20")
     * @Assert\NotBlank()
     */
    private $adresse;

    /**
     * @var integer
     *
     * @Assert\Length(min="3",max="10")
     * @Assert\NotBlank()
     * @ORM\Column(name="num_fiscale", type="integer", nullable=false)
     */
    private $numFiscale;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite_max", type="bigint", nullable=false)
     */
    private $quantiteMax;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var float
     *  @Assert\Length(min="3",max="20")
     * @Assert\NotBlank()
     * @ORM\Column(name="prix_location", type="float", length=20, nullable=false)
     */
    private $prixLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="entreprise", type="string", length=20, nullable=false)
     */
    private $entreprise;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $id;

    /**
     * @return int
     */
    public function getIdEntrepot()
    {
        return $this->idEntrepot;
    }

    /**
     * @param int $idEntrepot
     */
    public function setIdEntrepot($idEntrepot)
    {
        $this->idEntrepot = $idEntrepot;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return int
     */
    public function getNumFiscale()
    {
        return $this->numFiscale;
    }

    /**
     * @param int $numFiscale
     */
    public function setNumFiscale($numFiscale)
    {
        $this->numFiscale = $numFiscale;
    }

    /**
     * @return int
     */
    public function getQuantiteMax()
    {
        return $this->quantiteMax;
    }

    /**
     * @param int $quantiteMax
     */
    public function setQuantiteMax($quantiteMax)
    {
        $this->quantiteMax = $quantiteMax;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
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
     * @return string
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param string $entreprise
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;
    }

    /**
     * @return Utilisateur
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Utilisateur $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}