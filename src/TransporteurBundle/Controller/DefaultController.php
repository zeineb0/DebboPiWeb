<?php

namespace TransporteurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('@Transporteur/Admin/admin_page.html.twig');
    }








}
