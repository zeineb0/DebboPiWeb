<?php

namespace GererEntrepotBundle\Controller;

use GererEntrepotBundle\Entity\Entrepot;
use GererEntrepotBundle\Entity\Location;
use GererEntrepotBundle\GererEntrepotBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Location controller.
 *
 * @Route("")
 */
class LocationController extends Controller
{
    /**
     * Lists all location entities.
     *
     * @Route("location/", name="location_index")
     * @Method("GET")
     */
    public function indexAction()
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
        return $this->json($location->getFkEntrepot());

    }
    /**
     * Creates a new location entity.
     *
     * @Route("location/new/{idEntrepot}", name="location_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Entrepot $entrepot,Request $request)
    { $securityContext = $this->container->get('security.authorization_checker');
       if (!$entrepot->getIdEntrepot()){

           return $this->redirectToRoute('entrepot_a_louer');
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
    public function showAction(Location $location)
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
    public function editAction(Request $request, Location $location)
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
     * liste des locations pour l'admin .
     * @Route("/admin/location", name="location_admin")
     */
    public function showAllAction( )
    {   $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('GererEntrepotBundle:Location')->findAll();
        return $this->render('@GererEntrepot/admin/location.html.twig', array(
            'locations' => $locations,
        ));

    }
    /**
     * Deletes a location entity.
     *
     * @Route("location/{idLocation}/delete", name="location_delete")
     * @Method("DELETE")
     */
    public function deleteAction( $idLocation)
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
    private function createDeleteForm(Location $location)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('location_delete', array('idLocation' => $location->getIdlocation())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
