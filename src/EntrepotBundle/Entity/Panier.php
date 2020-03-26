<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\PanierRepository")
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
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_user")
     * })
     */
    private $idClient;


}