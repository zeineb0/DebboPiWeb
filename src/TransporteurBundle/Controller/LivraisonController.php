<?php

namespace TransporteurBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TransporteurBundle\Entity\Livraison;
use TransporteurBundle\Form\LivraisonType;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\SemaphoreStore;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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


    public function afficherCalendrierAction()
    {

        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserNotD($id=$this->getUser()->getId());

        $nbrLivraison=$this->getDoctrine()->getRepository(Livraison::class)->getNbrLivraison($id=$this->getUser()->getId());


        return $this->render("@Transporteur/Transporteur/accueil.html.twig",array("liste_livraison"=>$livraison,"nbr_livraison"=>$nbrLivraison));
    }


    public  function pageLivraisonAffecterAction(Request $request)
    {
        $nbrLivraison=$this->getDoctrine()->getRepository(Livraison::class)->getNbrLivraisonNonAff();
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonNonAff();
        $pagination = $this->get('knp_paginator')->paginate(
            $livraison, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render("@Transporteur/Fournisseur/list_livraison_affecter.html.twig",array("liste_livraison"=>$pagination,"nbr_livraison"=>$nbrLivraison));


    }



    public function affecterLivraisonAction($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->find($id);

        return $this->render("@Transporteur/Fournisseur/affecter_livraison.html.twig",array("livraison"=>$livraison));
    }


    public function getTransporteurAction(Request $request)
    {

        $transporteur=$this->getDoctrine()->getRepository(Livraison::class)->getTransporteur($request->get('adresse'),$request->get('dateLiv'));

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($transporteur);
        return new JsonResponse($formatted);

    }

    public function modifierLivraisonAction(Request $request)
    {
        //$livraison=$this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->getRepository(Livraison::class)->modifierLivraison($request->get('dateLiv'),$request->get('idUser'),$request->get('id'));
        $em->flush();
        return $this->redirectToRoute('livraison_affecter');


    }








}
