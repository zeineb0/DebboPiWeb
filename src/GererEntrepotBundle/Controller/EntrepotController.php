<?php

namespace GererEntrepotBundle\Controller;

use ClassesWithParents\E;
use EntrepotBundle\Entity\Utilisateur;
use GererEntrepotBundle\Data\SearchData;
use GererEntrepotBundle\Form\SearchForm;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;
use GererEntrepotBundle\Entity\Entrepot;
use GererEntrepotBundle\Entity\Location;
use GererEntrepotBundle\Repository\EntrepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Entrepot controller.
 *
 * @Route("")
 */
class EntrepotController extends Controller
{

    // affichage les depot à louer
    /**
     *
     * @Route("entrepot/alouer", name="entrepot_a_louer")
     */
    public function aLouerAction()
    { $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $entrepots= $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
            ->findBy(array('etat' => ['A Louer', 'En Attente']));
        $demandes =$this->getDoctrine()->getManager()->getRepository(Location::class)->findBy(array('fkEntrepot'=>$entrepots,'fkUser'=>$user));
           $i=0;
            $ent [] = new Entrepot();
            foreach($entrepots as $entrepot)
            {$test=false;
            if($user->getId()==$entrepot->getId()->getId()) {
                $test=true;
            }
                else
                {
                    foreach ($demandes as $demande)
                {
                    if ($demande->getfkEntrepot()->getIdEntrepot() ==$entrepot->getIdEntrepot())
                    {$test=true;
                    }

                }
                }
                if($test==false)
                {$ent[$i]=$entrepot;
                    $i++;
                }

            }

        return $this->render('@GererEntrepot/entrepot/alouer.html.twig', array(
            'entrepots' => $ent,


        ));
        }
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    /**
     * afficher entrepots loués.
     * @Route("entrepot/loue", name="entrepot_loue")
     */
    public function entrepotLouéAction( )
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $entrepots = $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
                ->findBy(array('id' => $user,'etat' => 'Loué'));
            return $this->render('@GererEntrepot/entrepot/loue.html.twig', array(
                'entrepots' => $entrepots,
            ));
        }

        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }

    }




    /**
     * afficher les demandes de location.
     * @Route("entrepot/demande", name="entrepot_demande_location")
     */
    public function entrepotDemandeAction(request $request )
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
         $em= $this->getDoctrine()->getManager();
           $query = $em->createQuery(
             "SELECT 
       e.idEntrepot id_Entrepot, e.adresse adresse , e.numFiscale numFiscale, e.entreprise entreprise , l.idLocation id_Location, l.dateDebLocation dateDebLocation,l.dateFinLocation dateFinLocation, l.prixLocation prixLocation, u.prenom prenom , u.nom nom, u.tel tel, u.email email
       FROM GererEntrepotBundle:Entrepot e  
           JOIN GererEntrepotBundle:Location l WITH e.idEntrepot = l.fkEntrepot and e.id = $user and e.etat = 'En Attente'
           JOIN EntrepotBundle:Utilisateur u WITH l.fkUser= u.id
           
           ");

            $entrepots = $query->getResult();
            return $this->render('@GererEntrepot/entrepot/demande.html.twig', array('entrepots' => $entrepots));


        }

        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }

    }



    /**
     * confirmer les demandes de location.
     * @Route("entrepot/demande/{idEntrepot}/confirmer", name="entrepot_confirme_demande")
     */
    public function confirmerDemandeAction($idEntrepot)
    {

        $em = $this->getDoctrine()->getManager();

        /* @var Entrepot $entrepotObj */
        $entrepotObj = $em->getRepository(Entrepot::class)->find($idEntrepot);

        $entrepotObj->setEtat('Loué');
        $em->persist($entrepotObj);
        $em->flush();
        /* @var Location $locationObj */
        $locationObj = $em->getRepository(Location::class)->findBy(array('fkEntrepot'=>$idEntrepot));
        $user=$locationObj[0]->getFkUser();
        $nom=$locationObj[0]->getFkUser()->getNom();
        $prenom=$locationObj[0]->getFkUser()->getPrenom();
        $email=$locationObj[0]->getFKUser()->getEmail();
        $username='debbopi@gmail.com';
        $message = \Swift_Message::newInstance()
            ->setSubject('Location Détail')
            ->setFrom($username)
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    '@GererEntrepot/entrepot/email.html.twig',array(
                        "nom" => $nom,"prenom"=>$prenom)
                ),
                'text/html'

            )
        ->attach(\Swift_Attachment::fromPath('C:\Users\asus\Desktop\Location.pdf'));
        $this->get('mailer')->send($message);

       

        return $this->redirectToRoute('entrepot_demande_location');

    }


    /**
     * confirmer les demandes de location.
     * @Route("entrepot/demande/{idLocation}/delete", name="entrepot_delete_demande")
     */
    public function deleteDemandeAction($idLocation)
    {

        $em = $this->getDoctrine()->getManager();
        /* @var Entrepot $entrepotObj */
        /* @var Location $locationObj */

        $em = $this->getDoctrine()->getManager();


        $locationObj = $em->getRepository(Location::class)->find($idLocation);
        $nom=$locationObj->getFkUser()->getNom();
        $prenom=$locationObj->getFkUser()->getPrenom();
        $email=$locationObj->getFKUser()->getEmail();
        $em->remove($locationObj);

        $form = $this->getDoctrine()->getRepository(Location::class)->findOneBy(array('idLocation'=>$idLocation));
        $idEntrepot = $form->getFkEntrepot();
        $entrepotObj=$em->getRepository(Entrepot::class)->find($idEntrepot);
        $entrepotObj->setEtat('A Louer');
        $em->persist($entrepotObj);
        $em->flush();

        $username='debbopi@gmail.com';
        $message = \Swift_Message::newInstance()
            ->setSubject('Location Détail')
            ->setFrom($username)
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    '@GererEntrepot/entrepot/emailref.html.twig',array(
                        "nom" => $nom,"prenom"=>$prenom)
                ),
                'text/html'

            );
        $this->get('mailer')->send($message);


        return $this->redirectToRoute('entrepot_demande_location');

    }




    /**
     * Lists all entrepot entities.
     *
     * @Route("entrepot/", name="entrepot_index")
     */
    public function indexAction(Request $request)
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();

            $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findBy(array('id'=>$user));
            /**
             * @var $paginator \Knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');

           $result =$paginator->paginate(
               $entrepots, /* query NOT result */
               $request->query->getInt('page', 1), /*page number*/
               $request->query->getInt('limit',10) /*limit per page*/
           );


        return $this->render('@GererEntrepot/entrepot/index.html.twig', [
            'entrepots' => $result,
        ]);
        }
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    /**
     * Creates a new entrepot entity.
     *
     * @Route("entrepot/new", name="entrepot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
        $entrepot = new Entrepot();
        $id= $this->getUser();
        $entrepot->setId($id);
        $form = $this->createForm('GererEntrepotBundle\Form\EntrepotType', $entrepot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entrepot);
            $em->flush();

            return $this->redirectToRoute('entrepot_show', array('idEntrepot' => $entrepot->getIdentrepot()));
        }

        return $this->render('@GererEntrepot/entrepot/new.html.twig', array(
            'entrepot' => $entrepot,
            'form' => $form->createView(),
        ));
        }
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    /**
     * liste des entrepots pour l'admin .
     * @Route("/admin/entrepot", name="entrepot_admin")
     */
    public function showAllAction( Request $request)
    {   $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result =$paginator->paginate(
            $entrepots, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',10) /*limit per page*/
        );

        return $this->render('@GererEntrepot/admin/index.html.twig', array(
            'entrepots' => $result,
        ));

    }


    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("entrepot/{idEntrepot}/edit", name="entrepot_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entrepot $entrepot)
    {
        $deleteForm = $this->createDeleteForm($entrepot);
        $editForm = $this->createForm('GererEntrepotBundle\Form\EntrepotType', $entrepot);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrepot_edit', array('idEntrepot' => $entrepot->getIdentrepot()));
        }

        return $this->render('@GererEntrepot/entrepot/edit.html.twig', array(
            'entrepot' => $entrepot,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("admin/entrepot/search", name="entrepot_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $data = $request->get('keyword');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
        SELECT c, u FROM GererEntrepotBundle:Entrepot c 
        JOIN c.id u
        WHERE u.username like :item')
            ->setParameter('item',  '%'.$data.'%');

        $entrepots = $query->getResult();


        return $this->render('@GererEntrepot/admin/index.html.twig', array(
            'entrepots' => $entrepots,
        ));

    }
    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("admin/entrepot/statistic", name="entrepot_statistic")
     * @Method({"GET", "POST"})
     */
    public function staticticAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $queryall = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
      ');

        $quantiteall = $queryall->getResult();
        $query = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
        WHERE c.etat =:item')
            ->setParameter('item','Loué');

        $quantite = $query->getResult();

        $query1 = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
        WHERE c.etat =:item')
            ->setParameter('item','A Louer');

        $quantite1 = $query1->getResult();
        $query2 = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
        WHERE c.etat =:item')
            ->setParameter('item','Libre');

        $quantite2 = $query2->getResult();

        $query3 = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
        WHERE c.etat =:item')
            ->setParameter('item','En Attente');

        $quantite3 = $query3->getResult();

        $pieChart = new PieChart();


        $pieChart->getData()->setArrayToDataTable(   [
            ['Etat','Pourcentage'],
                ['Libre', intval($quantite2[0]['cnt'])],
                ['a Louer',intval($quantite1[0]['cnt'])],
                ['Loué',intval($quantite[0]['cnt'])],
                ['En Attente', intval($quantite3[0]['cnt'])]
            ]
        );
        $pieChart->getOptions()->setTitle('Nombre d\'entrepot selon leurs etats ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('@GererEntrepot/admin/statistic.html.twig', array(
            'quantiteall' => $quantiteall[0],
            'quantite' => $quantite[0],
            'quantite1'=>$quantite1[0],
            'quantite2'=>$quantite2[0],
            'quantite3'=>$quantite3[0],
            'piechart' => $pieChart
        ));


    }


    /**
     *afficher les demandes de location entrepot entity.
     *
     * @Route("admin/entrepot/demande", name="admin_entrepot_demande")
     * @Method({"GET", "POST"})
     */
    public function demandeAdminAction(Request $request)
    {

            $em= $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                "SELECT 
       e.idEntrepot id_Entrepot, e.adresse adresse , e.numFiscale numFiscale, e.entreprise entreprise , l.idLocation id_Location, l.dateDebLocation dateDebLocation,l.dateFinLocation dateFinLocation, l.prixLocation prixLocation, u.prenom prenom , u.nom nom, u.tel tel, u.email email
       FROM GererEntrepotBundle:Entrepot e  
           JOIN GererEntrepotBundle:Location l WITH e.idEntrepot = l.fkEntrepot and e.etat = 'En Attente'
           JOIN EntrepotBundle:Utilisateur u WITH l.fkUser= u.id
           
           ");

            $entrepots = $query->getResult();
            return $this->render('@GererEntrepot/admin/demande.html.twig', array('entrepots' => $entrepots));






    }

    /**
     * Deletes a entrepot entity.
     *
     * @Route("admin/entrepot/{id}/delete", name="entrepot_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAdminAction( $id)
    {
        $form = $this->getDoctrine()->getRepository(Entrepot::class)->findBy(array("idEntrepot"=>$id));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

        return $this->redirectToRoute('entrepot_admin');
    }
    /**
     * Finds and displays a entrepot entity.
     *
     * @Route("admin /entrepot/{id}", name="entrepot_admin_details")
     * @Method("GET")
     */
    public function detailEntrepotAdminAction(Entrepot $entrepot)
    {
        $deleteForm = $this->createDeleteForm($entrepot);

        return $this->render('@GererEntrepot/admin/detailEntrepot.html.twig', array(
            'entrepot' => $entrepot,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Finds and displays a entrepot entity.
     *
     * @Route("entrepot/{idEntrepot}", name="entrepot_show")
     * @Method("GET")
     */
    public function showAction(Entrepot $entrepot)
    {
        $deleteForm = $this->createDeleteForm($entrepot);

        return $this->render('@GererEntrepot/entrepot/show.html.twig', array(
            'entrepot' => $entrepot,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Deletes a entrepot entity.
     *
     * @Route("entrepot/{idEntrepot}/delete", name="entrepot_delete")
     * @Method("DELETE")
     */
    public function deleteAction( $idEntrepot)
    {
        $form = $this->getDoctrine()->getRepository(Entrepot::class)->findBy(array("idEntrepot"=>$idEntrepot));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $entrepot) {
            $em->remove($entrepot);
        }

        $em->flush();

        return $this->redirectToRoute('entrepot_index');
    }

    /**
     * Creates a form to delete a entrepot entity.
     *
     * @param Entrepot $entrepot The entrepot entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entrepot $entrepot)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entrepot_delete', array('idEntrepot' => $entrepot->getIdentrepot())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }




}
