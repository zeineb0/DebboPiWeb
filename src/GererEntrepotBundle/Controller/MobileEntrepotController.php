<?php

namespace GererEntrepotBundle\Controller;

use GererEntrepotBundle\Entity\Entrepot;
use GererEntrepotBundle\Entity\Location;
use GererEntrepotBundle\GererEntrepotBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * MobileEntrepot controller.
 *
 * @Route("")
 */
class MobileEntrepotController extends Controller
{
    //******************************************Entrepot************************//

    // affichage les depot à louer
    /**
     *
     * @Route("entrepot/alouer", name="entrepot_a_louer")
     */
    public function aLouerAction()
    {

            $entrepots= $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
                ->findBy(array('etat' => ['A Louer', 'En Attente']));
            $demandes =$this->getDoctrine()->getManager()->getRepository(Location::class)->findBy(array('fkEntrepot'=>$entrepots,'fkUser'=>8));
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
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($ent, 'json');
            return new Response($jsonContent);

        }



    /**
     * afficher entrepots loués.
     * @Route("entrepot/loue", name="entrepot_loue")
     */
    public function entrepotLouéAction( )
    {
            $entrepots = $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
                ->findBy(array('id' => 8,'etat' => 'Loué'));
            return $this->render('@GererEntrepot/entrepot/loue.html.twig', array(
                'entrepots' => $entrepots,
            ));

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($ent, 'json');
        return new Response($jsonContent);

    }


    public function louerEntrepotAction (Request $request) {
        // id entropot
        //
    }

    /**
     * afficher les demandes de location.
     * @Route("entrepot/demande", name="entrepot_demande_location")
     */
    public function entrepotDemandeAction(request $request )
    {
            $em= $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                "SELECT 
       e.idEntrepot id_Entrepot, e.adresse adresse , e.numFiscale numFiscale, e.entreprise entreprise , l.idLocation id_Location, l.dateDebLocation dateDebLocation,l.dateFinLocation dateFinLocation, l.prixLocation prixLocation, u.prenom prenom , u.nom nom, u.tel tel, u.email email
       FROM GererEntrepotBundle:Entrepot e  
           JOIN GererEntrepotBundle:Location l WITH e.idEntrepot = l.fkEntrepot and e.id = 8 and e.etat = 'En Attente'
           JOIN EntrepotBundle:Utilisateur u WITH l.fkUser= u.id
           
           ");

            $entrepots = $query->getResult();

            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($entrepots, 'json');
            return new Response($jsonContent);


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
            ->setSubject('Location confirmation Détail')
            ->setFrom($username)
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    '@GererEntrepot/entrepot/email.html.twig',array(
                        "nom" => $nom,"prenom"=>$prenom)
                ),
                'text/html'

            );
        $this->get('mailer')->send($message);



        return $this->redirectToRoute('entrepot_demande_location');

    }


    /**
     * confirmer les demandes de location.
     * @Route("location/demande/{idLocation}/delete", name="entrepot_delete_demande")
     */
    public function deleteDemandeAction($idLocation)
    {

        $em = $this->getDoctrine()->getManager();
        /* @var Entrepot $entrepotObj */
        /* @var Location $locationObj */

        $em = $this->getDoctrine()->getManager();

        $locationObj = $em->getRepository(Location::class)->find($idLocation);

        $em->remove($locationObj);

        $form = $this->getDoctrine()->getRepository(Location::class)->findOneBy(array('idLocation'=>$idLocation));
        $idEntrepot = $form->getFkEntrepot();
        $entrepotObj=$em->getRepository(Entrepot::class)->find($idEntrepot);
        $entrepotObj->setEtat('A Louer');
        $em->persist($entrepotObj);
        $em->flush();

        return $this->redirectToRoute('entrepot_demande_location');

    }




    /**
     * Lists all entrepot entities.
     *
     * @Route("entrepotM/", name="entrepot_index")
     */
    public function indexAction()
    {
            $em = $this->getDoctrine()->getManager();

            $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepots, 'json');
        return new Response($jsonContent);


    }


    /**
     * Creates a new entrepot entity.
     *
     * @Route("entrepotM/new", name="entrepot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
            $entrepot = new Entrepot();
            $id= $this->getUser();
            $entrepot->setId($id);
            $form = $this->createForm('GererEntrepotBundle\Form\EntrepotType', $entrepot);
            $form->handleRequest($request);
            


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepot, 'json');
        return new Response($jsonContent);

    }

    /**
     * liste des entrepots pour l'admin .
     * @Route("/admin/entrepot", name="entrepot_admin")
     */
    public function showAllAction( )
    {   $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepots, 'json');
        echo $jsonContent;
        return new Response($jsonContent);

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

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepot, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
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

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepots, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
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

        return $this->render('@GererEntrepot/admin/statistic.html.twig', array(
            'quantiteall' => $quantiteall[0],

            'quantite' => $quantite[0],
            'quantite1'=>$quantite1[0],
            'quantite2'=>$quantite2[0],
            'quantite3'=>$quantite3[0]));


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

////*************Location*********//
    /**
     * Lists all location entities.
     *
     * @Route("location/", name="location_index")
     * @Method("GET")
     */
    public function indexLAction()
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $em = $this->getDoctrine()->getManager();

            $locations = $em->getRepository('GererEntrepotBundle:Location')->findBy(array('fkUser'=>$user));

            return $this->render('@GererEntrepot/location/index.html.twig', array(
                'locations' => $locations,

            ));
        }
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
    /**
     * @Route("/location/{id}/pdf", name="location_pdf")
     */
    public function pdfAction($id)
    {
        $snappy = $this->get('knp_snappy.pdf');


        $em = $this->getDoctrine()->getManager();

        /* @var Location $location */
        $location = $em->getRepository(Location::class)->find($id);
        $s=$location->getFkEntrepot();
        $entrepot = $em->getRepository(Entrepot::class)->findBy(['idEntrepot' => $s]);


        $html = $this->renderView('@GererEntrepot/location/Pdf.html.twig',
            array(
                'entrepot' => $entrepot,
                'location' => $location,
            ));

        $filename = 'myFirstSnappyPDF';
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );

    }



    public function confirmationAction(Location $location){

        $em = $this->getDoctrine()->getManager();
        $em->persist($location);
        $em->flush();
        $entrepot=$em->getRepository('GererEntrepotBundle:Entrepot')->findOneBy(array('idEntrepot'=>$location->getFkEntrepot()));
        $entrepot->setEtat('En Attente');
        $em->persist($entrepot);
        $em->flush();
        return $this->json($location->getFkEntrepot()->getIdEntrepot());

    }

    /**
     * @Route("location/confirmer", name="location_accepter")
     */
    public function confirmerAction(){
        return $this->render('@GererEntrepot/location/test.html.twig');
    }
    /**
     * Creates a new location entity.
     *
     * @Route("location/new/{idEntrepot}", name="location_new")
     * @Method({"GET", "POST"})
     */
    public function newLAction(Entrepot $entrepot,Request $request)
    { $securityContext = $this->container->get('security.authorization_checker');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $test =$this->getDoctrine()->getManager()->getRepository('GererEntrepotBundle:Location')
            ->findOneBy(array('fkEntrepot'=>$entrepot->getIdEntrepot(),'fkUser'=>$user));
        if ($test){

            return $this->redirectToRoute('location_accepter');
        }
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
            $location = new Location();
            $form = $this->createForm('GererEntrepotBundle\Form\LocationType', $location);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $id= $this->getUser();
                $location->setFkUser($id);
                $location->setFkEntrepot($entrepot);
                $prix=$entrepot->getPrixLocation();
                $datDeb = new \DateTime($location->getDateDebLocation()->format('Y/m/d'));
                $datFin = new \DateTime($location->getDateFinLocation()->format('Y/m/d'));

                $location->setPrixLocation(($datFin->diff($datDeb)->days)*($prix/30));

                return $this->render('@GererEntrepot/location/confirmation.html.twig', array(
                    'location' => $location,

                ));
            }

            return $this->render('@GererEntrepot/location/new.html.twig', array(
                'location' => $location,
                'form' => $form->createView(),

            ));

            return $this->render('@GererEntrepot/location/new.html.twig');
        }
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    /**
     * Finds and displays a location entity.
     *
     * @Route("location/{idLocation}", name="location_show")
     * @Method("GET")
     */
    public function showLAction(Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);

        return $this->render('@GererEntrepot/location/show.html.twig', array(
            'location' => $location,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing location entity.
     *
     * @Route("location/{idLocation}/edit", name="location_edit")
     * @Method({"GET", "POST"})
     */
    public function editLAction(Request $request, Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);
        $editForm = $this->createForm('GererEntrepotBundle\Form\LocationType', $location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $prix=$location->getFkEntrepot()->getPrixLocation();
            $datDeb = new \DateTime($location->getDateDebLocation()->format('Y/m/d'));
            $datFin = new \DateTime($location->getDateFinLocation()->format('Y/m/d'));

            $location->setPrixLocation(($datFin->diff($datDeb)->days)*($prix/30));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_show', array('idLocation' => $location->getIdlocation()));
        }

        return $this->render('@GererEntrepot/location/edit.html.twig', array(
            'location' => $location,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("admin/location/statistic", name="location_statistic")
     * @Method({"GET", "POST"})
     */
    public function staticticlocAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Location c 
        
      ');

        $quantite = $query->getResult();


        $query3 = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
        WHERE c.etat =:item')
            ->setParameter('item','En Attente');

        $quantite3 = $query3->getResult();

        return $this->render('@GererEntrepot/admin/staticticLocation.html.twig', array(

            'quantite' => $quantite[0],

            'quantite3'=>$quantite3[0]));


    }
    /**
     * liste des locations pour l'admin .
     * @Route("/admin/location", name="location_admin")
     */
    public function showAllLAction( )
    {   $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('GererEntrepotBundle:Location')->findAll();
        return $this->render('@GererEntrepot/admin/location.html.twig', array(
            'locations' => $locations,
        ));

    }

    /**
     * Deletes a entrepot entity.
     *
     * @Route("admin/location/{id}/delete", name="location_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAdminLAction( $idLocation)
    {
        $form = $this->getDoctrine()->getRepository(Location::class)->findBy(array("idEntrepot"=>$idLocation));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

        return $this->redirectToRoute('location_admin');
    }
    /**
     * Finds and displays a entrepot entity.
     *
     * @Route("admin /location/{id}", name="location_admin_details")
     * @Method("GET")
     */
    public function detailEntrepotAdminLAction(Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);

        return $this->render('@GererEntrepot/admin/detailLocation.html.twig', array(
            'location' => $location,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * Deletes a location entity.
     *
     * @Route("location/{idLocation}/delete", name="location_delete")
     * @Method("DELETE")
     */
    public function deleteLAction( $idLocation)
    {
        $form = $this->getDoctrine()->getRepository(Location::class)->findBy(array("idLocation"=>$idLocation));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

        return $this->redirectToRoute('location_index');
    }

    /**
     * Creates a form to delete a location entity.
     *
     * @param Location $location The location entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteLForm(Location $location)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('location_delete', array('idLocation' => $location->getIdlocation())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
