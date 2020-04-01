<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * MouvementDuStock
 *
 * @ORM\Table(name="mouvement_du_stock", indexes={@ORM\Index(name="Mouvement_du_stock_Entrepot", columns={"FK_id_entrepot"}), @ORM\Index(name="Mouvement_du_stock_Produit", columns={"FK_id_produit"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\MouvementDuStockRepository")
 */
class MouvementDuStock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_mouv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMouv;

    /**
     * @var string
     *
     * @ORM\Column(name="nature_mouvement", type="string", length=255, nullable=false)
     */
    private $natureMouvement;

    /**
     * @var string
     *
     * @ORM\Column(name="date_mouv", type="string", length=30, nullable=false)
     */
    private $dateMouv;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=30, nullable=false)
     */
    private $annee;

    /**
     * @var integer
     *
     * @ORM\Column(name="NombreProd", type="integer", nullable=false)
     */
    private $nombreprod;

    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="GererEntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEntrepot;

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