<?php

namespace TransporteurBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TransporteurBundle\Entity\Livraison;

class AdminController extends Controller
{
    public function indexAction()
    {

        $stat=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonParRegion();
        dump($stat);
        $transporteur=$this->getDoctrine()->getRepository(User::class)->getNbrTransporteur();
        dump($transporteur);
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getNbrLivraisonTOT();

        return $this->render('@Transporteur/Admin/admin_page.html.twig',array("stat"=>$stat,"nbr_transporteur"=>$transporteur,"nbr_livraison"=>$livraison));
    }








}
