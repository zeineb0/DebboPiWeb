<?php

namespace TransporteurBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TransporteurBundle\Entity\Contrat;
use TransporteurBundle\Entity\Livraison;
use TransporteurBundle\Form\ContratType;
use TransporteurBundle\Form\LivraisonType;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\SemaphoreStore;


class ContratController extends Controller
{



    public function ajouterContratAction(Request $request)
    {

     /*   $store = new SemaphoreStore();
        $factory = new Factory($store);
        $lock = $factory->createLock('the-lock-name', 30); */


        $contrat = new Contrat();
        $form=$this->createForm(ContratType::class,$contrat);

        $form->handleRequest($request);

        if ($form ->isSubmitted() and $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($contrat);
            $em->flush();
           // return $this->redirectToRoute('');
        }

        return $this->render("@Transporteur/Transporteur/ajouter_contrat.html.twig",array("form"=>$form->createView()));



    }

    public function getAllLivraisonAction()
    {


        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->findAll();
        return $this->render("@Transporteur/Transporteur/afficher_livraison_all.html.twig",array("liste_livraison"=>$livraison));
    }


    public function supprimerLivraisonAction($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($livraison);
        $em->flush();
        return $this->getAllLivraisonAction();

    }

    public function afficherLivraisonParTransporteurNonLivreAction()
    {
        //$user=new User();
        //$user->setId($id);
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserNotD($id=$this->getUser()->getId());
        return $this->render("@Transporteur/Transporteur/afficher_livraison_all.html.twig",array("liste_livraison"=>$livraison));

    }

    public function afficherLivraisonParTransporteurLivreAction()
    {

        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserD($id=$this->getUser()->getId());
        return $this->render("@Transporteur/Transporteur/afficher_livraison_all.html.twig",array("liste_livraison"=>$livraison));

    }


    public function modifierEtatLivraisonAction($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->getRepository(Livraison::class)->updateLivStat($livraison);
        $em->flush();
        return $this->getAllLivraisonAction(); // à terminer


    }






}
