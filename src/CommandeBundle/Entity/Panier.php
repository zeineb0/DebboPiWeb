<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\PanierRepository")
 */
class Panier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPanier;

    /**
     * @var string
     *
     * @ORM\Column(name="list_produit", type="string", length=1000, nullable=false)
     */
    private $listProduit;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_produit", type="integer", nullable=false)
     */
    private $nbrProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_panier", type="string", length=1, nullable=false)
     */
    private $etatPanier;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_user")
     * })
     */
    private $idClient;

    /**
     * @return int
     */
    public function getIdPanier()
    {
        return $this->idPanier;
    }

    /**
     * @param int $idPanier
     */
    public function setIdPanier($idPanier)
    {
        $this->idPanier = $idPanier;
    }

    /**
     * @return string
     */
    public function getListProduit()
    {
        return $this->listProduit;
    }

    /**
     * @param string $listProduit
     */
    public function setListProduit($listProduit)
    {
        $this->listProduit = $listProduit;
    }

    /**
     * @return int
     */
    public function getNbrProduit()
    {
        return $this->nbrProduit;
    }

    /**
     * @param int $nbrProduit
     */
    public function setNbrProduit($nbrProduit)
    {
        $this->nbrProduit = $nbrProduit;
    }

    /**
     * @return string
     */
    public function getEtatPanier()
    {
        return $this->etatPanier;
    }

    /**
     * @param string $etatPanier
     */
    public function setEtatPanier($etatPanier)
    {
        $this->etatPanier = $etatPanier;
    }

    /**
     * @return \Utilisateur
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param \Utilisateur $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }


}