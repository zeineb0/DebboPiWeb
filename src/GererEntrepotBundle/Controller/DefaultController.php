<?php

namespace GererEntrepotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@GererEntrepot/Default/index.html.twig');
    }
}
