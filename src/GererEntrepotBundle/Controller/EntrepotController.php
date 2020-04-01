<?php

namespace GererEntrepotBundle\Controller;

use GererEntrepotBundle\Entity\Entrepot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Entrepot controller.
 *
 * @Route("entrepot")
 */
class EntrepotController extends Controller
{
    /**
     * Lists all entrepot entities.
     *
     * @Route("/", name="entrepot_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();

        return $this->render('@GererEntrepot/entrepot/index.html.twig', array(
            'entrepots' => $entrepots,
        ));
    }

    /**
     * Creates a new entrepot entity.
     *
     * @Route("/new", name="entrepot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entrepot = new Entrepot();
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

    /**
     * Finds and displays a entrepot entity.
     *
     * @Route("/{idEntrepot}", name="entrepot_show")
     * @Method("GET")
     */
    public function showAction(Entrepot $entrepot)
    {
        $deleteForm = $this->createDeleteForm($entrepot);

        return $this->render('@GererEntrepot/entrepot/show.html.twig', array(
            'entrepot' => $entrepot,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("/{idEntrepot}/edit", name="entrepot_edit")
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
     * Deletes a entrepot entity.
     *
     * @Route("/{idEntrepot}", name="entrepot_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Entrepot $entrepot)
    {
        $form = $this->createDeleteForm($entrepot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entrepot);
            $em->flush();
        }

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
