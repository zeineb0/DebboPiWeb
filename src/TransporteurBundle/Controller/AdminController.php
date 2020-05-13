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

        $livraison_nonL=$this->getDoctrine()->getRepository(Livraison::class)->getpercentageNLiv();
        dump($livraison_nonL);
        $livraison_L=$this->getDoctrine()->getRepository(Livraison::class)->getpercentageLiv();




        return $this->render('@Transporteur/Admin/admin_page.html.twig',array("stat"=>$stat,"nbr_transporteur"=>$transporteur,"nbr_livraison"=>$livraison,"nbr_liv_NL"=>$livraison_nonL,"nbr_liv_L"=>$livraison_L));
    }








}
