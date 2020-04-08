<?php

namespace GererEntrepotBundle\Controller;

use GererEntrepotBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Location controller.
 *
 * @Route("location")
 */
class LocationController extends Controller
{
    /**
     * Lists all location entities.
     *
     * @Route("/", name="location_index")
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
     * Creates a new location entity.
     *
     * @Route("/new", name="location_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    { $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
        $location = new Location();

        $form = $this->createForm('GererEntrepotBundle\Form\LocationType', $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('location_show', array('idLocation' => $location->getIdlocation()));
        }

        return $this->render('@GererEntrepot/location/new.html.twig', array(
            'location' => $location,
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
     * Finds and displays a location entity.
     *
     * @Route("/{idLocation}", name="location_show")
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
     * @Route("/{idLocation}/edit", name="location_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);
        $editForm = $this->createForm('GererEntrepotBundle\Form\LocationType', $location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_edit', array('idLocation' => $location->getIdlocation()));
        }

        return $this->render('@GererEntrepot/location/edit.html.twig', array(
            'location' => $location,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a location entity.
     *
     * @Route("/{idLocation}/delete", name="location_delete")
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
