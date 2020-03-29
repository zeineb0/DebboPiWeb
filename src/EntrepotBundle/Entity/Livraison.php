<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="Livraison_Commande", columns={"FK_id_commande"}), @ORM\Index(name="Livraison_Utilisateur", columns={"FK_id_user"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\LivraisonRepository")
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
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_commande", referencedColumnName="id_commande")
     * })
     */
    private $fkCommande;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_user", referencedColumnName="id_user")
     * })
     */
    private $fkUser;


}