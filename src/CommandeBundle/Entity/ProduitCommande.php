<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * ProduitCommande
 *
 * @ORM\Table(name="produit_commande", indexes={@ORM\Index(name="id_cmd", columns={"id_commande"}),@ORM\Index(name="id_prd", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\ProduitCommandeRepository")
 */
class ProduitCommande
{   /**
 * @var \float
 *
 * @ORM\Column(name="prix_produit", type="float", nullable=false)
 */
    private $prixProduit;

    /**
     * @var \float
     *
     * @ORM\Column(name="quantite_produit", type="float", nullable=false)
     */
    private $quantiteProduit;


    /**
     * @var \Produit
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id_produit")
     * })

     */
    private $idProduit;

    /**
     * @var \Commande
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commande", referencedColumnName="id_commande")
     * })

     */
    private $idCommande;

    /**
     * @return float
     */
    public function getPrixProduit()
    {
        return $this->prixProduit;
    }

    /**
     * @param float $prixProduit
     */
    public function setPrixProduit($prixProduit)
    {
        $this->prixProduit = $prixProduit;
    }

    /**
     * @return float
     */
    public function getQuantiteProduit()
    {
        return $this->quantiteProduit;
    }

    /**
     * @param float $quantiteProduit
     */
    public function setQuantiteProduit($quantiteProduit)
    {
        $this->quantiteProduit = $quantiteProduit;
    }

    /**
     * @return \Produit
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param \Produit $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return \Commande
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * @param \Commande $idCommande
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }


}