<?php

namespace EntrepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Categories
 *
 * @ORM\Table(name="categories" , indexes={@ORM\Index(name="FK_3AF34668E12857FB", columns={"FK_id_entrepot"})})
 * @ORM\Entity(repositoryClass="EntrepotBundle\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @return int
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * @param int $idCategorie
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
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
     *
     * @return string
     */
    public function __toString(){
        return $this->nom;
    }
    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;
    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_id_entrepot", referencedColumnName="id_entrepot")
     * })
     */
    private $fkEntrepot;

    /**
     * @return \Utilisateur
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \Utilisateur $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \Entrepot
     */
    public function getFkEntrepot()
    {
        return $this->fkEntrepot;
    }

    /**
     * @param \Entrepot $fkEntrepot
     */
    public function setFkEntrepot($fkEntrepot)
    {
        $this->fkEntrepot = $fkEntrepot;
    }


}