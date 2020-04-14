<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\mailRepository")
 */
class Mail
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
     * @ORM\Column(name="exp", type="string", length=255)
     */
    private $exp;

    /**
     * @var string
     *
     * @ORM\Column(name="des", type="string", length=255)
     */
    private $des;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set exp
     *
     * @param string $exp
     *
     * @return mail
     */
    public function setExp($exp)
    {
        $this->exp = $exp;
    
        return $this;
    }

    /**
     * Get exp
     *
     * @return string
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * Set des
     *
     * @param string $des
     *
     * @return mail
     */
    public function setDes($des)
    {
        $this->des = $des;
    
        return $this;
    }

    /**
     * Get des
     *
     * @return string
     */
    public function getDes()
    {
        return $this->des;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return mail
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    
        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return mail
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
}

