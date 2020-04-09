<?php

namespace GererEntrepotBundle\Controller;

use EntrepotBundle\Entity\Utilisateur;
use GererEntrepotBundle\Entity\Entrepot;
use GererEntrepotBundle\Repository\EntrepotRepository;
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

    // affichage les depot à louer
    /**
     *
     * @Route("/showe_a_louer", name="entrepot_a_louer")
     */
    public function showeAction()
    {
        $entrepots= $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
            ->findBy(['etat' => 'A Louer']);

        /* @var $etn Entrepot */
        $etn = new Entrepot();

        /* @var $user Utilisateur */
        $user = $etn->getId();


        //$entrepots =$repository->afficherEtatALouer();

        return $this->render('@GererEntrepot/entrepot/alouer.html.twig', array(
            'entrepots' => $entrepots,
            // $ent = $location->getEnt();
            //        $znt->setEt
        ));
    }
    /**
     * afficher entrepots loués.
     * @Route("/loué", name="entrepot_loué")
     */
    public function entrepotLouéAction( )
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $entrepots = $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
                ->findBy(array('id' => $user,'etat' => 'Loué'));
            return $this->render('@GererEntrepot/entrepot/alouer.html.twig', array(
                'entrepots' => $entrepots,
            ));
        }

        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }

    }


    public function louerEntrepotAction (Request $request) {
        // id entropot
        //
    }

    /**
     * Deletes a entrepot entity.
     * @Route("/admin", name="entrepot_admin")
     */
    public function adminAction( )
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $this->render('admin.html.twig');
            }

        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }

    }


    /**
     * Lists all entrepot entities.
     *
     * @Route("/", name="entrepot_index")
     */
    public function indexAction()
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findBy(array('id'=>$user));

        return $this->render('@GererEntrepot/entrepot/index.html.twig', array(
            'entrepots' => $entrepots,
        ));
        }
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    /**
     * Creates a new entrepot entity.
     *
     * @Route("/new", name="entrepot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {   $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
        $entrepot = new Entrepot();
        $id= $this->getUser();
        $entrepot->setId($id);
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
        # if user not logged in yet
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
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
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Deletes a entrepot entity.
     *
     * @Route("/{idEntrepot}/delete", name="entrepot_delete")
     * @Method("DELETE")
     */
    public function deleteAction( $idEntrepot)
    {
        $form = $this->getDoctrine()->getRepository(Entrepot::class)->findBy(array("idEntrepot"=>$idEntrepot));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

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
