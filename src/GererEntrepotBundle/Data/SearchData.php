<?php

namespace GererEntrepotBundle\Data;

use GererEntrepotBundle\Entity\Entrepot;

class SearchData
{
    /**
     * @var string
     */
    public  $adresse = '';


    /**
     * @var Entrepot[]
     */
    public $entreprise = [];

    /**
     * @var null|integer
     */
    public  $min ;
    /**
     * @var null|integer
     */
    public  $max;
}