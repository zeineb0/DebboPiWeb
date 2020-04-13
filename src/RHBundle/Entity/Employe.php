<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Employe
 * @ORM\Table(name="employe", indexes={@ORM\Index(name="fk_emp", columns={"FK_id_dep"})})
 * @ORM\Entity(repositoryClass="RHBundle\Repository\EmployeRepository")
 * @Vich\Uploadable
 */
class Employe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_emp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmp;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Saisir un nom valide SVP",
     *     )
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Saisir un prenom valide SVP",
     *     )
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\Length(
     *      min=8,
     *     max=8,
     *     )
     * @ORM\Column(name="cin", type="string", length=8, nullable=false)
     */
    private $cin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_embauche", type="datetime", nullable=false,options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateEmbauche;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_empmois", type="date", nullable=true)
     */
    private $dateEmpMois;

    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float", precision=10, scale=0, nullable=false)
     */
    private $salaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer", nullable=false)
     */
    private $points=0;

    /**
     * @var string
     *
     * @ORM\Column(name="recommandations", type="string", length=100, nullable=false)
     */
    private $recommandations;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="employees", fileNameProperty="imageName")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="signalemp", type="integer", nullable=false)
     */
    private $signalemp=0;



    /**
     * @return int
     */
    public function getSignalemp()
    {
        return $this->signalemp;
    }

    /**
     * @param int $signalemp
     */
    public function setSignalemp($signalemp)
    {
        $this->signalemp = $signalemp;
    }


    /**
     * @return int
     */
    public function getIdEmp()
    {
        return $this->idEmp;
    }

    /**
     * @param int $idEmp
     */
    public function setIdEmp($idEmp)
    {
        $this->idEmp = $idEmp;
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
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param string $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return \DateTime
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }

    /**
     * @param \DateTime $dateEmbauche
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;
    }

    /**
     * @return float
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * @param float $salaire
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getRecommandations()
    {
        return $this->recommandations;
    }

    /**
     * @param string $recommandations
     */
    public function setRecommandations($recommandations)
    {
        $this->recommandations = $recommandations;
    }

    /**
     * @return \Departement
     */
    public function getFkDep()
    {
        return $this->fkDep;
    }

    /**
     * @param \Departement $fkDep
     */
    public function setFkDep($fkDep)
    {
        $this->fkDep = $fkDep;
    }

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_id_dep", referencedColumnName="id_dep")
     * })
     */
    private $fkDep;

    /**
     * @return \DateTime
     */
    public function getDateEmpMois()
    {
        return $this->dateEmpMois;
    }

    /**
     * @param \DateTime $dateEmpMois
     */
    public function setDateEmpMois($dateEmpMois)
    {
        $this->dateEmpMois = $dateEmpMois;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function __construct()
    {
        $now = new \Datetime();
        $this->setDateEmbauche($now);
    }




}