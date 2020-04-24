<?php

namespace TransporteurBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TransporteurBundle\Entity\Livraison;
use TransporteurBundle\Form\LivraisonType;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\SemaphoreStore;


class LivraisonController extends Controller
{



    public function ajouterLivraisonAction(Request $request)
    {

     /*   $store = new SemaphoreStore();
        $factory = new Factory($store);
        $lock = $factory->createLock('the-lock-name', 30); */


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
        return $this->redirectToRoute('aff_liv_Trans_L');

    }

    public function afficherLivraisonParTransporteurNonLivreAction(Request $request)
    {
        //$user=new User();
        //$user->setId($id);
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserNotD($id=$this->getUser()->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $livraison, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1 /*limit per page*/
        );

       return $this->render("@Transporteur/Transporteur/liste_livraisons_non_livres.html.twig",array("liste_livraison"=>$pagination));

    }

    public function afficherLivraisonParTransporteurLivreAction(Request $request)
    {

        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserD($id=$this->getUser()->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $livraison, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );


        return $this->render("@Transporteur/Transporteur/liste_livraisons_livres.html.twig",array("liste_livraison"=>$pagination));

    }


    public function modifierEtatLivraisonAction($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->getRepository(Livraison::class)->updateLivStat($livraison);
        $em->flush();
        return $this->redirectToRoute('aff_liv_Trans_L');


    }






}
