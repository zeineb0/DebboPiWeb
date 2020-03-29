<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * ProduitCommande
 *
 * @ORM\Table(name="produit_commande", indexes={@ORM\Index(name="id_cmd", columns={"id_commande"}),@ORM\Index(name="id_prd", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\ProduitCommandeRepository")
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
     * @ORM\ManyToOne(targetEntity="StockBundle\Entity\Produit")
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


}