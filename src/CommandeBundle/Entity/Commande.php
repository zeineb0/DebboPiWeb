<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="commande_ibfk_1", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\CommandeRepository")
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
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_user")
     * })
     */
    private $idClient;

    /**
     * @return int
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * @param int $idCommande
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getTypePaiement()
    {
        return $this->typePaiement;
    }

    /**
     * @param string $typePaiement
     */
    public function setTypePaiement($typePaiement)
    {
        $this->typePaiement = $typePaiement;
    }

    /**
     * @return \DateTime
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * @param \DateTime $dateCommande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
    }

    /**
     * @return \DateTime
     */
    public function getDateExp()
    {
        return $this->dateExp;
    }

    /**
     * @param \DateTime $dateExp
     */
    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;
    }

    /**
     * @return \Utilisateur
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param \Utilisateur $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }





}