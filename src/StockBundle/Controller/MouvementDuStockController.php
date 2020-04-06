<?php

namespace StockBundle\Controller;

use StockBundle\Entity\MouvementDuStock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mouvementdustock controller.
 *
 * @Route("mouvementdustock")
 */
class MouvementDuStockController extends Controller
{
    /**
     * Lists all mouvementDuStock entities.
     *
     * @Route("/", name="mouvementdustock_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mouvementDuStocks = $em->getRepository('StockBundle:MouvementDuStock')->findAll();

        return $this->render('@Stock/mouvementdustock/index.html.twig', array(
            'mouvementDuStocks' => $mouvementDuStocks,
        ));
    }

    /**
     * Creates a new mouvementDuStock entity.
     *
     * @Route("/new", name="mouvementdustock_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mouvementDuStock = new Mouvementdustock();
        $mouvementDuStock->setDateMouv(new \DateTime('now'));


        $form = $this->createForm('StockBundle\Form\MouvementDuStockType', $mouvementDuStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $id=$this->getUser();
            $mouvementDuStock->setIdUser($id);

            $em->persist($mouvementDuStock);
            $em->flush();

            return $this->redirectToRoute('mouvementdustock_show', array('idMouv' => $mouvementDuStock->getIdmouv()));
        }

        return $this->render('@Stock/mouvementdustock/new.html.twig', array(
            'mouvementDuStock' => $mouvementDuStock,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mouvementDuStock entity.
     *
     * @Route("/{idMouv}", name="mouvementdustock_show")
     * @Method("GET")
     */
    public function showAction(MouvementDuStock $mouvementDuStock)
    {
        $deleteForm = $this->createDeleteForm($mouvementDuStock);

        return $this->render('@Stock/mouvementdustock/show.html.twig', array(
            'mouvementDuStock' => $mouvementDuStock,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mouvementDuStock entity.
     *
     * @Route("/{idMouv}/edit", name="mouvementdustock_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MouvementDuStock $mouvementDuStock)
    {
        $deleteForm = $this->createDeleteForm($mouvementDuStock);
        $editForm = $this->createForm('StockBundle\Form\MouvementDuStockType', $mouvementDuStock);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mouvementdustock_edit', array('idMouv' => $mouvementDuStock->getIdmouv()));
        }

        return $this->render('@Stock/mouvementdustock/edit.html.twig', array(
            'mouvementDuStock' => $mouvementDuStock,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mouvementDuStock entity.
     *
     * @Route("/{idMouv}", name="mouvementdustock_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MouvementDuStock $mouvementDuStock)
    {
        $form = $this->createDeleteForm($mouvementDuStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mouvementDuStock);
            $em->flush();
        }

        return $this->redirectToRoute('mouvementdustock_index');
    }

    /**
     * Creates a form to delete a mouvementDuStock entity.
     *
     * @param MouvementDuStock $mouvementDuStock The mouvementDuStock entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MouvementDuStock $mouvementDuStock)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mouvementdustock_delete', array('idMouv' => $mouvementDuStock->getIdmouv())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
