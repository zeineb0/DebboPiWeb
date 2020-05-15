<?php

namespace RHBundle\Controller;

use RHBundle\Entity\conge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Conge controller.
 *
 */
class congeController extends Controller
{
    /**
     * Lists all conge entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conges = $em->getRepository('RHBundle:conge')->findAll();

        return $this->render('@RH/conge/index.html.twig', array(
            'conges' => $conges,
        ));
    }

    /**
     * Creates a new conge entity.
     *
     */
    public function newAction(Request $request)
    {
        $conge = new Conge();
        $form = $this->createForm('RHBundle\Form\congeType', $conge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conge);
            $em->flush();

            return $this->redirectToRoute('conge_show', array('id' => $conge->getId()));
        }

        return $this->render('@RH/conge/new.html.twig', array(
            'conge' => $conge,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conge entity.
     *
     */
    public function showAction(conge $conge)
    {
        $deleteForm = $this->createDeleteForm($conge);

        return $this->render('@RH/conge/show.html.twig', array(
            'conge' => $conge,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conge entity.
     *
     */
    public function editAction(Request $request, conge $conge)
    {
        $deleteForm = $this->createDeleteForm($conge);
        $editForm = $this->createForm('RHBundle\Form\congeType', $conge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conge_edit', array('id' => $conge->getId()));
        }

        return $this->render('@RH/conge/edit.html.twig', array(
            'conge' => $conge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conge entity.
     *
     */
    public function deleteAction(Request $request, conge $conge)
    {
        $form = $this->createDeleteForm($conge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conge);
            $em->flush();
        }

        return $this->redirectToRoute('conge_index');
    }

    /**
     * Creates a form to delete a conge entity.
     *
     * @param conge $conge The conge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(conge $conge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conge_delete', array('id' => $conge->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
