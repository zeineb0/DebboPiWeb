<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location", indexes={@ORM\Index(name="Location_Entrepot", columns={"FK_id_entrepot"}), @ORM\Index(name="Location_Utilisateur", columns={"FK_id_user"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_location", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLocation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb_location", type="date", nullable=false)
     */
    private $dateDebLocation;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_location", type="date", nullable=false)
     */
    private $dateFinLocation;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_location", type="float", precision=10, scale=10, nullable=false)
     */
    private $prixLocation;

    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEntrepot;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_user", referencedColumnName="id_user")
     * })
     */
    private $fkUser;


}