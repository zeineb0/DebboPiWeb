<?php

namespace StockBundle\Controller;

use StockBundle\Entity\Produit;
use StockBundle\Entity\Categories;
use EntrepotBundle\Entity\Entrepot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Produit controller.
 *
 * @Route("produit")
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="produit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $produits = $em->getRepository('StockBundle:Produit')->findBy(array('idUser'=>$user));
        $categorys = $em->getRepository('StockBundle:Categories')->findBy(array('idUser'=>$user));
        $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->findBy(array ('idUser'=>$user));
        $i=0;
        $p=0;
        foreach ($produits as $produit){


                    $p=$p+ $produits[$i]->getQuantite(); $i++;

                }

            return $this->render('@Stock/produit/index.html.twig', array(
            'produits' => $produits,
                'categorys'=>$categorys,
                'entrepots'=>$entrepots,
                'p'=>$p
        ));
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produit = new Produit();
        $form = $this->createForm('StockBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);
        $idconnected = $this->getUser()->getId();
        $users = $em->getRepository('AppBundle:User')->findAll();
        $category = $em->getRepository('StockBundle:Categories')->findAll();
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $id = $this->getUser();
            $produit->setIdUser($id);
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('@Stock/produit/new.html.twig', array(
            'produit' => $produit,
            'idconnected'=>$idconnected,
            'users'=>$users,
            'category'=>$category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{idProduit}", name="produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('@Stock/produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{idProduit}/edit", name="produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('StockBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('produit_edit', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('@Stock/produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('idProduit' => $produit->getIdproduit())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
 * Deletes a produit entity.
 *
 * @Route("/{idProduit}/delete", name="produit_delete")
 * @Method("DELETE")
 */
    public function deleteAction( $idProduit)
    {
        $form = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);
        $em=$this->getDoctrine()->getManager();

        $em->
        remove($form);

        $em->flush();

        return $this->redirectToRoute('produit_index');
    }


}
