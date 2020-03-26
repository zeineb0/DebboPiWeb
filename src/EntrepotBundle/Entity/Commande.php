<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="commande_ibfk_1", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="type_paiement", type="string", length=20, nullable=false)
     */
    private $typePaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="date", nullable=false)
     */
    private $dateCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_exp", type="date", nullable=false)
     */
    private $dateExp;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_user")
     * })
     */
    private $idClient;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", inversedBy="idCommande")
     * @ORM\JoinTable(name="produit_commande",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_commande", referencedColumnName="id_commande")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_produit", referencedColumnName="id_produit")
     *   }
     * )
     */
    private $idProduit;




}