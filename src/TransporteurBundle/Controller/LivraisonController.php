<?php

namespace TransporteurBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TransporteurBundle\Entity\Livraison;
use TransporteurBundle\Form\LivraisonType;

class LivraisonController extends Controller
{



    public function ajouterLivraisonAction(Request $request)
    {

        $livraison = new Livraison();
        $form=$this->createForm(LivraisonType::class,$livraison);

        $form->handleRequest($request);

        if ($form ->isSubmitted() and $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            return $this->redirectToRoute('afficher_livraison_all');
        }

        return $this->render("@Transporteur/Transporteur/ajouter_livraison.html.twig",array("form"=>$form->createView()));
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


    public function modifierEtatLivraison($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->updateLivStat($livraison);   // à terminer


    }






}
