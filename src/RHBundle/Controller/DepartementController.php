<?php

namespace RHBundle\Controller;


use RHBundle\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Departement controller.
 *
 */
class DepartementController extends Controller
{
    /**
     * Lists all departement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $departements = $em->getRepository('RHBundle:Departement')->findAll();

        return $this->render('@RH/departement/index.html.twig', array(
            'departements' => $departements,
        ));
    }

    /**
     * Creates a new departement entity.
     *
     */
    public function newAction(Request $request)
    {
        $departement = new Departement();
        $form = $this->createForm('RHBundle\Form\DepartementType', $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departement);
            $em->flush();

            return $this->redirectToRoute('dep_show', array('idDep' => $departement->getIddep()));
        }

        return $this->render('@RH/departement/new.html.twig', array(
            'departement' => $departement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a departement entity.
     *
     */
    public function showAction(Departement $departement)
    {
        $deleteForm = $this->createDeleteForm($departement);

        return $this->render('@RH/departement/show.html.twig', array(
            'departement' => $departement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing departement entity.
     *
     */
    public function editAction(Request $request, Departement $departement)
    {
        $deleteForm = $this->createDeleteForm($departement);
        $editForm = $this->createForm('RHBundle\Form\DepartementType', $departement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dep_edit', array('idDep' => $departement->getIddep()));
        }

        return $this->render('@RH/departement/edit.html.twig', array(
            'departement' => $departement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a departement entity.
     *
     */
    public function deleteAction(Request $request, Departement $departement)
    {
        $form = $this->createDeleteForm($departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($departement);
            $em->flush();
        }

        return $this->redirectToRoute('dep_index');
    }

    /**
     * Creates a form to delete a departement entity.
     *
     * @param Departement $departement The departement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Departement $departement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dep_delete', array('idDep' => $departement->getIddep())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function  rechercheAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $motcledep=$request->get('motcledep');

        $departement = $em->getRepository('RHBundle:Departement')->findBy( array('nom' =>$motcledep) );

        return $this->render('@RH/Departement/index.html.twig', array(
            'departements' => $departement,
        ));
    }
    public function nbempAction($idDep){
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(idemp) FROM RHBundle:Employe WHERE employe.idemp= :iddep');
        return
    }

}
