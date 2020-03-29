<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Entrepot
 *
 * @ORM\Table(name="entrepot", indexes={@ORM\Index(name="FK_id_user", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\EntrepotRepository")
 */
class Entrepot
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_entrepot", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEntrepot;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=10, nullable=false)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_fiscale", type="integer", nullable=false)
     */
    private $numFiscale;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite_max", type="bigint", nullable=false)
     */
    private $quantiteMax;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="entreprise", type="string", length=20, nullable=false)
     */
    private $entreprise;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;


}