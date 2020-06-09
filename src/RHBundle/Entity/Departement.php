<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Departement
 *
 * @ORM\Table(name="departement", indexes={@ORM\Index(name="fk_ent", columns={"FK_id_ent"})})
 * @ORM\Entity(repositoryClass="RHBundle\Repository\DepartementRepository")
 * @UniqueEntity("nom")
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
     * @ORM\Column(name="nom", type="string", length=30, nullable=false,unique=true)
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
     * @ORM\ManyToOne(targetEntity="GererEntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_ent", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEnt;

    /**
     * @return int
     */
    public function getIdDep()
    {
        return $this->idDep;
    }

    /**
     * @param int $idDep
     */
    public function setIdDep($idDep)
    {
        $this->idDep = $idDep;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * @param int $etage
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;
    }

    /**
     * @return int
     */
    public function getNbsalles()
    {
        return $this->nbsalles;
    }

    /**
     * @param int $nbsalles
     */
    public function setNbsalles($nbsalles)
    {
        $this->nbsalles = $nbsalles;
    }

    /**
     * @return float
     */
    public function getBudgetannuel()
    {
        return $this->budgetannuel;
    }

    /**
     * @param float $budgetannuel
     */
    public function setBudgetannuel($budgetannuel)
    {
        $this->budgetannuel = $budgetannuel;
    }

    /**
     * @return \Entrepot
     */
    public function getFkEnt()
    {
        return $this->fkEnt;
    }

    /**
     * @param \Entrepot $fkEnt
     */
    public function setFkEnt($fkEnt)
    {
        $this->fkEnt = $fkEnt;
    }


}