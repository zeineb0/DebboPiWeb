<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\Length(
     *     min = 20,
     *     minMessage="Votre Publication est courte"
     * )
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datec", type="datetime")
     */
    private $datec;

    /**
     * @var int
     *
     * @ORM\Column(name="idPublication", type="integer")
     */
    private $idPublication;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="EntrepotBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $idUser;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set datec
     *
     * @param \DateTime $datec
     *
     * @return Commentaire
     */
    public function setDatec($datec)
    {
        $this->datec = $datec;

        return $this;
    }

    /**
     * Get datec
     *
     * @return \DateTime
     */
    public function getDatec()
    {
        return $this->datec;
    }

    /**
     * Set idPublication
     *
     * @param integer $idPublication
     *
     * @return Commentaire
     */
    public function setIdPublication($idPublication)
    {
        $this->idPublication = $idPublication;

        return $this;
    }

    /**
     * Get idPublication
     *
     * @return int
     */
    public function getIdPublication()
    {
        return $this->idPublication;
    }

    /**
     * Set idUser
     *
     * @param \EntrepotBundle\Entity\User $idUser
     *
     * @return Commentaire
     */
    public function setIdUser(\EntrepotBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \EntrepotBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}
