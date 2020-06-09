<?php

namespace TransporteurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="Livraison_Commande", columns={"FK_id_commande"}), @ORM\Index(name="Livraison_Utilisateur", columns={"FK_id_user"})})
 * @ORM\Entity(repositoryClass="TransporteurBundle\Repository\LivraisonRepository")
 */
class Livraison
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_livraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLivraison;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_livraison", type="date", nullable=false)
     */
    private $dateLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_livraison", type="string", length=30, nullable=false)
     */
    private $adresseLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_livraison", type="string", length=20, nullable=false)
     */
    private $etatLivraison;

    /**
     * @var integer
     *
     * @ORM\Column(name="longitude_dest", type="integer", nullable=true)
     */
    private $longitudeDest;

    /**
     * @var integer
     *
     * @ORM\Column(name="altitude_dest", type="integer", nullable=true)
     */
    private $altitudeDest;

    /**
     * @var string
     *
     * @ORM\Column(name="acceptation", type="string", length=20, nullable=false)
     */
    private $acceptation;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="GererEntrepotBundle\Entity\Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_commande", referencedColumnName="id_commande")
     * })
     */
    private $fkCommande;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_user", referencedColumnName="id_user")
     * })
     */
    private $fkUser;

  /*  /**
     * Livraison constructor.
     * @param int $idLivraison
     * @param \DateTime $dateLivraison
     * @param string $adresseLivraison
     * @param string $etatLivraison
     * @param string $acceptation
     * @param \Commande $fkCommande
     * @param \User $fkUser
     /


    public function __construct( \DateTime $dateLivraison, $adresseLivraison, $etatLivraison, $acceptation, \Commande $fkCommande, \User $fkUser)
    {

        $this->dateLivraison = $dateLivraison;
        $this->adresseLivraison = $adresseLivraison;
        $this->etatLivraison = $etatLivraison;
        $this->acceptation = $acceptation;
        $this->fkCommande = $fkCommande;
        $this->fkUser = $fkUser;
    }
*/









    /**
     * @return int
     */
    public function getIdLivraison()
    {
        return $this->idLivraison;
    }

    /**
     * @param int $idLivraison
     */
    public function setIdLivraison($idLivraison)
    {
        $this->idLivraison = $idLivraison;
    }

    /**
     * @return \DateTime
     */
    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    /**
     * @param \DateTime $dateLivraison
     */
    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;
    }

    /**
     * @return string
     */
    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    /**
     * @param string $adresseLivraison
     */
    public function setAdresseLivraison($adresseLivraison)
    {
        $this->adresseLivraison = $adresseLivraison;
    }

    /**
     * @return string
     */
    public function getEtatLivraison()
    {
        return $this->etatLivraison;
    }

    /**
     * @param string $etatLivraison
     */
    public function setEtatLivraison($etatLivraison)
    {
        $this->etatLivraison = $etatLivraison;
    }

    /**
     * @return int
     */
    public function getLongitudeDest()
    {
        return $this->longitudeDest;
    }

    /**
     * @param int $longitudeDest
     */
    public function setLongitudeDest($longitudeDest)
    {
        $this->longitudeDest = $longitudeDest;
    }

    /**
     * @return int
     */
    public function getAltitudeDest()
    {
        return $this->altitudeDest;
    }

    /**
     * @param int $altitudeDest
     */
    public function setAltitudeDest($altitudeDest)
    {
        $this->altitudeDest = $altitudeDest;
    }

    /**
     * @return string
     */
    public function getAcceptation()
    {
        return $this->acceptation;
    }

    /**
     * @param string $acceptation
     */
    public function setAcceptation($acceptation)
    {
        $this->acceptation = $acceptation;
    }

    /**
     * @return \Commande
     */
    public function getFkCommande()
    {
        return $this->fkCommande;
    }

    /**
     * @param \Commande $fkCommande
     */
    public function setFkCommande($fkCommande)
    {
        $this->fkCommande = $fkCommande;
    }

    /**
     * @return \User
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }

    /**
     * @param \User $fkUser
     */
    public function setFkUser($fkUser)
    {
        $this->fkUser = $fkUser;
    }


}