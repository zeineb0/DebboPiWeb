<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement", indexes={@ORM\Index(name="fk_ent", columns={"FK_id_ent"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dep", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDep;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="etage", type="integer", nullable=false)
     */
    private $etage;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbsalles", type="integer", nullable=false)
     */
    private $nbsalles;

    /**
     * @var float
     *
     * @ORM\Column(name="budgetannuel", type="float", precision=10, scale=0, nullable=false)
     */
    private $budgetannuel;


    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_ent", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEnt;

}