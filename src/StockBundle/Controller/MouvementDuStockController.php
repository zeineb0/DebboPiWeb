<?php

namespace StockBundle\Controller;

use StockBundle\Entity\MouvementDuStock;
use StockBundle\Entity\Produit;
use StockBundle\Form\MouvementDuStockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use StockBundle\Form\ProduitType;
use Symfony\Component\HttpFoundation\Response;
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
    public function indexAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql="SELECT bp FROM StockBundle:MouvementDuStock bp";
        $query=$em->createQuery($dql);
       // $mouvementDuStocks = $em->getRepository('StockBundle:MouvementDuStock')->findAll();
        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
       $result= $paginator->paginate(
          $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5)
        );
        return $this->render('@Stock/mouvementdustock/index.html.twig', array(
            'mouvementDuStocks' => $result,
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
            $mouvementDuStock->setIdUser($this->getUser());
            $id=$mouvementDuStock->getFkProduit();

            $fk=$id->getIdProduit();
            $qte=$_POST['QA'];
            if ($mouvementDuStock->getNatureMouvement()=='Sortie') {
                if ($id->getQuantite() < $qte)

                {
                    return $this->render('@Stock/mouvementdustock/msg.html.twig');
                }
                else {

                    $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                    $update=$rrepo->updateProduit($mouvementDuStock,$qte,$fk);
                }
                }

                elseif ($id->getQuantite() >= $qte)
                    {
                $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                $update=$rrepo->updateProduit($mouvementDuStock,$qte,$fk);
                    }

            $em->persist($mouvementDuStock);
            $em->flush();
            return $this->redirectToRoute('mouvementdustock_show', array('idMouv' => $mouvementDuStock->getIdMouv()));

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

        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            $id=$mouvementDuStock->getFkProduit();
            $fk=$id->getIdProduit();
            $qte=$_POST['QA'];
            if ($mouvementDuStock->getNatureMouvement()=='Sortie') {
                if ($id->getQuantite() < $qte)

                {return $this->render('@Stock/mouvementdustock/msg.html.twig');}
                else {

                    $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                    $update=$rrepo->updateProduit($mouvementDuStock,$qte,$fk);
                }
            }

            elseif ($id->getQuantite() >= $qte)
            {
                $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                $update=$rrepo->updateProduit($mouvementDuStock,$qte,$fk);
            }

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


    /**
     * Deletes a mouvement entity.
     *
     * @Route("/{idMouv}/delete", name="mouvementdustock_delete")
     * @Method("DELETE")
     */
    public function deleteAction($idMouv)
    {
        $this->
        $form = $this->getDoctrine()->getRepository(MouvementDuStock::class)->find($idMouv);
        var_dump($form);
        $em=$this->getDoctrine()->getManager();

        $em->remove($form);
        $em->flush();


        return $this->redirectToRoute('mouvementdustock_index');
    }


}
