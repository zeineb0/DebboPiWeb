<?php

namespace TransporteurBundle\Controller;

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
           // return $this->redirectToRoute('readFormation');
        }



        return $this->render("@Transporteur/Transporteur/ajouter_livraison.html.twig",array("form"=>$form->createView()));
    }






}
