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
use Knp\Component\Pager\Paginator;
use TransporteurBundle\Service\UtilsService;


class ContratController extends Controller
{



    public function ajouterContratAction(Request $request)
    {

        $contrat = new Contrat();
        $form=$this->createForm(ContratType::class,$contrat);

        $form->handleRequest($request);

        if ($form ->isSubmitted() and $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($contrat);
            $em->flush();
            // return $this->redirectToRoute('');

            $nom=$contrat->getFKiduser()->getNom();
            $prenom=$contrat->getFKiduser()->getPrenom();
            $entreprise=$contrat->getFKidentrepot()->getEntreprise();
            $email=$contrat->getFKiduser()->getEmail();
            $username='debbopi@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setSubject('Contrat Détail')
                ->setFrom($username)
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        '@Transporteur/Email/email_template.html.twig',array(
                            "nom" => $nom,"entreprise"=>$entreprise,"prenom"=>$prenom)
                    ),
                    'text/html'

                );
            $this->get('mailer')->send($message);

        }

        $contrat=$this->getDoctrine()->getRepository(Contrat::class)->getContratByProp($id=$this->getUser()->getId());



        $pagination = $this->get('knp_paginator')->paginate(
            $contrat, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1 /*limit per page*/
        );


        $nbrContrat = $this->getDoctrine()->getRepository(Contrat::class)->getNbrContrat();



       return $this->render("@Transporteur/Fournisseur/afficher_contrat.html.twig",array("form"=>$form->createView(),"liste_contrat"=>$pagination,"nbr_conrat"=>$nbrContrat));

    }

    public function afficherContratExpAction(Request $request)
    {
        $contrat=$this->getDoctrine()->getRepository(Contrat::class)->getListContratExp($id=$this->getUser()->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $contrat, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1 /*limit per page*/
        );


        return $this->render("@Transporteur/Fournisseur/afficher_contrat_exp.html.twig",array("liste_contrat"=>$pagination));

    }




    public function supprimerContratAction($FKidentrepot,$FKiduser)
    {
        $contrat=$this->getDoctrine()->getRepository(Contrat::class)->findOneBy(array('FKidentrepot'=>$FKidentrepot ,'FKiduser'=>$FKiduser ));
        $em=$this->getDoctrine()->getManager();
        $em->remove($contrat);
        $em->flush();
        return $this->redirectToRoute('afficher_contrat');

    }

    public function modifierContratAction(Request $request, $FKidentrepot,$FKiduser)
    {

        $contrat = $this->getDoctrine()->getRepository(Contrat::class)->findOneBy(array('FKidentrepot'=>$FKidentrepot ,'FKiduser'=>$FKiduser ));
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contrat);
            $em->flush();
            return $this->redirectToRoute("afficher_contrat");
        }

        return $this->render("@Transporteur/Fournisseur/modifier_contrat.html.twig",array("form"=>$form->createView()));

    }





}
