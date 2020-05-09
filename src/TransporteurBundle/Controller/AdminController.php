<?php

namespace TransporteurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TransporteurBundle\Entity\Livraison;

class AdminController extends Controller
{
    public function indexAction()
    {

        $stat=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonParRegion();
        dump($stat);

        return $this->render('@Transporteur/Admin/admin_page.html.twig',array("stat"=>$stat));
    }








}
