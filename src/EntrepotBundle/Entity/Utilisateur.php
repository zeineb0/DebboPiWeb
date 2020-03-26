<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="fk_pd", columns={"FK_id_produit"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=10, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=10, nullable=false)
     */
    private $prenom;

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
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=30, nullable=false)
     */
    private $role;

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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=240, nullable=false)
     */
    private $password;

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

}

