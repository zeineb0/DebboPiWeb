<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * conge
 *
 * @ORM\Table(name="conge")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\congeRepository")
 */
class conge
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
     * @var \DateTime
     *
     * @ORM\Column(name="datesortie", type="date")
     */
    private $datesortie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datearrive", type="date")
     */
    private $datearrive;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="FK_id_emp", type="integer")
     */
    private $fKIdEmp;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->$id = $id;

        return $this;
    }
    /**
     * Set datesortie
     *
     * @param \DateTime $datesortie
     *
     * @return conge
     */
    public function setDatesortie($datesortie)
    {
        $this->datesortie = $datesortie;
    
        return $this;
    }

    /**
     * Get datesortie
     *
     * @return \DateTime
     */
    public function getDatesortie()
    {
        return $this->datesortie;
    }

    /**
     * Set datearrive
     *
     * @param \DateTime $datearrive
     *
     * @return conge
     */
    public function setDatearrive($datearrive)
    {
        $this->datearrive = $datearrive;
    
        return $this;
    }

    /**
     * Get datearrive
     *
     * @return \DateTime
     */
    public function getDatearrive()
    {
        return $this->datearrive;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return conge
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return conge
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set fKIdEmp
     *
     * @param integer $fKIdEmp
     *
     * @return conge
     */
    public function setFKIdEmp($fKIdEmp)
    {
        $this->fKIdEmp = $fKIdEmp;
    
        return $this;
    }

    /**
     * Get fKIdEmp
     *
     * @return integer
     */
    public function getFKIdEmp()
    {
        return $this->fKIdEmp;
    }
}

