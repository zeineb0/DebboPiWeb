<?php

namespace StockBundle\Entity;

use Cassandra\Date;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * MouvementDuStock
 *
 * @ORM\Table(name="mouvement_du_stock", indexes={@ORM\Index(name="Mouvement_du_stock_Entrepot", columns={"FK_id_entrepot"}), @ORM\Index(name="Mouvement_du_stock_Produit", columns={"FK_id_produit"})})
 * @ORM\Entity(repositoryClass="StockBundle\Repository\MouvementDuStockRepository")
 */
class MouvementDuStock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_mouv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMouv;

    /**
     * @var string
     *
     * @ORM\Column(name="nature_mouvement", type="string", length=255, nullable=false)
     */
    private $natureMouvement;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_mouv", type="date", length=30, nullable=false)
     */
    private $dateMouv;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=30, nullable=true)
     */
    private $annee;

    /**
     * @var integer
     *
     * @ORM\Column(name="NombreProd", type="integer", nullable=true)
     */
    private $nombreprod;

    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEntrepot;

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
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @return int
     */
    public function getIdMouv()
    {
        return $this->idMouv;
    }

    /**
     * @param int $idMouv
     */
    public function setIdMouv($idMouv)
    {
        $this->idMouv = $idMouv;
    }

    /**
     * @return string
     */
    public function getNatureMouvement()
    {
        return $this->natureMouvement;
    }

    /**
     * @param string $natureMouvement
     */
    public function setNatureMouvement($natureMouvement)
    {
        $this->natureMouvement = $natureMouvement;
    }

    /**
     * @return string
     */
    public function getDateMouv()
    {
        return $this->dateMouv;
    }

    /**
     * @param string $dateMouv
     */
    public function setDateMouv($dateMouv)
    {
        $this->dateMouv = $dateMouv;
    }

    /**
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param string $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    /**
     * @return int
     */
    public function getNombreprod()
    {
        return $this->nombreprod;
    }

    /**
     * @param int $nombreprod
     */
    public function setNombreprod($nombreprod)
    {
        $this->nombreprod = $nombreprod;
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

    /**
     * @return \Utilisateur
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \Utilisateur $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }



}