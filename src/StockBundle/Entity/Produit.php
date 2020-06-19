<?php

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fk_en", columns={"FK_id_entrepot"}), @ORM\Index(name="Produit_Categories", columns={"FK_id_categorie"})})
 * @ORM\Entity(repositoryClass="StockBundle\Repository\ProduitRepository")
 * @Vich\Uploadable
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="promotion", type="boolean", nullable=true)
     */
    private $promotion;

    /**
     * @var integer
     *@Assert\NotBlank()
     * @Assert\Length(min=8)
     * @Assert\Length(max=8)
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    private $reference;

    /**
     * @var string
     * *@Assert\Type(
     *     type="string"
     * )
     * @ORM\Column(name="marque", type="string", length=255, nullable=false)
     */
    private $marque;

    /**
     * @var float
     *@Assert\Type(
     *     type="float"
     * )
     * @ORM\Column(name="prix", type="float", precision=7, scale=2, nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;
    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_categorie", referencedColumnName="id_categorie",nullable=false)
     * })
     */
    private $fkCategorie;

    /**
     * @var \Entrepot
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\Entrepot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_entrepot", referencedColumnName="id_entrepot",nullable=false)
     * })
     */
    private $fkEntrepot;
    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="produit", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     */
    private $imageName;
    /**
     * @var string
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;




    public function __toString()
    {
            return $this->libelle;
    }


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
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     *
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Categories
     */
    public function getFkCategorie()
    {
        return $this->fkCategorie;
    }

    /**
     * @param \Categories $fkCategorie
     */
    public function setFkCategorie($fkCategorie)
    {
        $this->fkCategorie = $fkCategorie;
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

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile($imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * @return bool
     */
    public function isPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param bool $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}