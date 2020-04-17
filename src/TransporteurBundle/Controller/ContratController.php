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


    public function afficherContratParPropEAction()
    {
        $contrat=$this->getDoctrine()->getRepository(Contrat::class)->getContratByProp($id=$this->getUser()->getId());
        return $this->render("@Transporteur/Transporteur/afficher_contrat.html.twig",array("liste_contrat"=>$contrat));

    }


    public function supprimerContratAction($FKidentrepot,$FKiduser)
    {
        $contrat=$this->getDoctrine()->getRepository(Contrat::class)->findOneBy(array('FKidentrepot'=>$FKidentrepot ,'FKiduser'=>$FKiduser ));
        $em=$this->getDoctrine()->getManager();
        $em->remove($contrat);
        $em->flush();
        return $this->afficherContratParPropEAction();

    }



}
