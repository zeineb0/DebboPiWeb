<?php

namespace RHBundle\Entity;

/**
 * Email
 */
class Email
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $expediteur;

    /**
     * @var string
     */
    private $destination;

    /**
     * @var string
     */
    private $sujet;

    /**
     * @var string
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
     * Set expediteur
     *
     * @param string $expediteur
     *
     * @return Email
     */
    public function setExpediteur($expediteur)
    {
        $this->expediteur = $expediteur;
    
        return $this;
    }

    /**
     * Get expediteur
     *
     * @return string
     */
    public function getExpediteur()
    {
        return $this->expediteur;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Email
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    
        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Email
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
     * @return Email
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

