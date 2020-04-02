<?php

namespace EntrepotBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as FOSUser;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="fk_pd", columns={"FK_id_produit"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends FOSUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=10, nullable=false)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=10, nullable=false)
     */
    protected $prenom;

    /**
     * @var integer
     *
     * @ORM\Column(name="cin", type="bigint", nullable=false)
     */
    private $cin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;


    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="bigint", nullable=false)
     */
    private $tel;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude_user", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitudeUser;

    /**
     * @var float
     *
     * @ORM\Column(name="altitude_user", type="float", precision=10, scale=0, nullable=true)
     */
    private $altitudeUser;


    /**
     * @var string
     *
     * @ORM\Column(name="disponniblite", type="string", length=20, nullable=false)
     */
    private $disponniblite;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_maxComm", type="integer", nullable=true)
     */
    private $nbrMaxcomm;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_produit", referencedColumnName="id_produit")
     * })
     */
    private $fkProduit;

    /**
     * Utilisateur constructor.
     * @param int $id
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return float
     */
    public function getLongitudeUser()
    {
        return $this->longitudeUser;
    }

    /**
     * @param float $longitudeUser
     */
    public function setLongitudeUser($longitudeUser)
    {
        $this->longitudeUser = $longitudeUser;
    }

    /**
     * @return float
     */
    public function getAltitudeUser()
    {
        return $this->altitudeUser;
    }

    /**
     * @param float $altitudeUser
     */
    public function setAltitudeUser($altitudeUser)
    {
        $this->altitudeUser = $altitudeUser;
    }

    /**
     * @return string
     */
    public function getDisponniblite()
    {
        return $this->disponniblite;
    }

    /**
     * @param string $disponniblite
     */
    public function setDisponniblite($disponniblite)
    {
        $this->disponniblite = $disponniblite;
    }

    /**
     * @return int
     */
    public function getNbrMaxcomm()
    {
        return $this->nbrMaxcomm;
    }

    /**
     * @param int $nbrMaxcomm
     */
    public function setNbrMaxcomm($nbrMaxcomm)
    {
        $this->nbrMaxcomm = $nbrMaxcomm;
    }

    /**
     * @return \Produit
     */
    public function getFkProduit()
    {
        return $this->fkProduit;
    }

    /**
     * @param \Produit $fkProduit
     */
    public function setFkProduit($fkProduit)
    {
        $this->fkProduit = $fkProduit;
    }


}

