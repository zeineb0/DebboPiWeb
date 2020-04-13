<?php

namespace StockBundle\Controller;

use StockBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller.
 *
 * @Route("categories")
 */
class CategoriesController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="categories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $idconnected = $this->getUser()->getId();
        $users = $em->getRepository('AppBundle:User')->findAll();
        $categories = $em->getRepository('StockBundle:Categories')->findAll();

        return $this->render('@Stock/categories/index.html.twig', array(
            'categories' => $categories,'idconnected'=>$idconnected, 'users'=>$users
        ));
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="categories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categories = new Categories();
        $form = $this->createForm('StockBundle\Form\CategoriesType', $categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $id = $this->getUser();
            $categories->setIdUser($id);
            $em->persist($categories);
            $em->flush();

            return $this->redirectToRoute('categories_show', array('idCategorie' => $categories->getIdcategorie()));
        }

        return $this->render('@Stock/categories/new.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{idCategorie}", name="categories_show")
     * @Method("GET")
     */
    public function showAction(Categories $categories)
    {
        $deleteForm = $this->createDeleteForm($categories);

        return $this->render('@Stock/categories/show.html.twig', array(
            'category' => $categories,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{idCategorie}/edit", name="categories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categories $categories)
    {
        $deleteForm = $this->createDeleteForm($categories);
        $editForm = $this->createForm('StockBundle\Form\CategoriesType', $categories);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categories_edit', array('idCategorie' => $categories->getIdcategorie()));
        }

        return $this->render('@Stock/categories/edit.html.twig', array(
            'category' => $categories,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{idCategorie}/delete", name="categories_delete")
     * @Method("DELETE")
     */
    public function deleteAction($idCategorie)
    {
        $form = $this->getDoctrine()->getRepository(Categories::class)->find($idCategorie);
        var_dump($form);
        $em=$this->getDoctrine()->getManager();

        $em->remove($form);
        $em->flush();


        return $this->redirectToRoute('categories_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Categories $categories The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categories $categories)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categories_delete', array('idCategorie' => $categories->getIdcategorie())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
