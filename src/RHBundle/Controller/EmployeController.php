<?php

namespace RHBundle\Controller;

use RHBundle\Entity\Employe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Employe controller.
 *
 */
class EmployeController extends Controller
{
    /**
     * Lists all employe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $employes = $em->getRepository('RHBundle:Employe')->findAll();
        return $this->render('@RH/Employe/index.html.twig', array(
            'employes' => $employes,
        ));
    }

    /**
     * Creates a new employe entity.
     *
     */
    public function newAction(Request $request)
    {
        $employe = new Employe();
        $form = $this->createForm('RHBundle\Form\EmployeType', $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employe);
            $em->flush();
            $this->addFlash('info', 'Employee ajoutée avec succées');
            return $this->redirectToRoute('employe_show', array('idEmp' => $employe->getIdemp()));
        }

        return $this->render('@RH/Employe/new.html.twig', array(
            'employe' => $employe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a employe entity.
     *
     */
    public function showAction(Employe $employe)
    {
        $deleteForm = $this->createDeleteForm($employe);
        $this->addFlash('info', 'Voici les informations de votre employée');
        return $this->render('@RH/Employe/show.html.twig', array(
            'employe' => $employe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing employe entity.
     *
     */
    public function editAction(Request $request, Employe $employe)
    {
        $deleteForm = $this->createDeleteForm($employe);
        $editForm = $this->createForm('RHBundle\Form\EmployeType', $employe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employe_index', array('idEmp' => $employe->getIdemp()));
        }
        $this->addFlash('info', 'Modification faites avec succées');

        return $this->render('@RH/Employe/edit.html.twig', array(
            'employe' => $employe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a employe entity.
     *
     */
    public function deleteAction(Request $request, Employe $employe)
    {
        $form = $this->createDeleteForm($employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employe);
            $em->flush();
        }
        $this->addFlash('info', 'Employée suppriméé avec succées');
        return $this->redirectToRoute('employe_index');
    }

    /**
     * Creates a form to delete a employe entity.
     *
     * @param Employe $employe The employe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Employe $employe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employe_delete', array('idEmp' => $employe->getIdemp())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function  rechercheAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $motcle=$request->get('motcle');
        $employes = $em->getRepository('RHBundle:Employe')->findBy( array('cin' =>$motcle) );
        $this->addFlash('info', 'Voici la résultat de votre recherche');

        return $this->render('@RH/Employe/index.html.twig', array(
            'employes' => $employes, 'motcle' => $motcle,
        ));
    }
    public function empdateAction($dateEmbauche){
        $dateEmbauche =new \DateTime('now');
    }



}
