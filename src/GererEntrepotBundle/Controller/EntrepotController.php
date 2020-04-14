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
 * @Route("")
 */
class EntrepotController extends Controller
{

    // affichage les depot à louer
    /**
     *
     * @Route("entrepot/alouer", name="entrepot_a_louer")
     */
    public function aLouerAction()
    {// $user
        //$demande -> findLocation by user

        $entrepots= $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
            ->findBy(array('etat' => ['A Louer', 'En Attente']));
//entre2 nexiste pas demande
   // for

      //for ()
       //   if bool
         // entre2+entre

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
     * @Route("entrepot/loué", name="entrepot_loué")
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
     * Lists all entrepot entities.
     *
     * @Route("entrepot/", name="entrepot_index")
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
     * @Route("entrepot/new", name="entrepot_new")
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
     * liste des entrepots pour l'admin .
     * @Route("/admin/entrepot", name="entrepot_admin")
     */
    public function showAllAction( )
    {   $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();
        return $this->render('@GererEntrepot/admin/index.html.twig', array(
            'entrepots' => $entrepots,
        ));

    }


    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("entrepot/{idEntrepot}/edit", name="entrepot_edit")
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
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("admin/entrepot/search", name="entrepot_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $data = $request->get('keyword');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
        SELECT c, u FROM GererEntrepotBundle:Entrepot c 
        JOIN c.id u
        WHERE u.username like :item')
            ->setParameter('item',  '%'.$data.'%');

        $commandes = $query->getResult();

        return $this->render('@GererEntrepot/admin/index.html.twig', array('entrepots' => $commandes));


    }
    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("admin/entrepot/statistic", name="entrepot_statistic")
     * @Method({"GET", "POST"})
     */
    public function staticticAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
        SELECT COUNT(c) cnt FROM GererEntrepotBundle:Entrepot c 
        
        WHERE c.etat =:item')
            ->setParameter('item','Loué');

        $quantite = $query->getResult();

        return $this->render('@GererEntrepot/admin/statistic.html.twig', array('quantite' => $quantite[0]));


    }
    /**
     * Deletes a entrepot entity.
     *
     * @Route("admin/entrepot/{id}/delete", name="entrepot_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAdminAction( $idEntrepot)
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
     * Finds and displays a entrepot entity.
     *
     * @Route("entrepot/{id}", name="entrepot_admin_details")
     * @Method("GET")
     */
    public function detailEntrepotAdminAction(Entrepot $entrepot)
    {
        $deleteForm = $this->createDeleteForm($entrepot);

        return $this->render('@GererEntrepot/admin/detailEntrepot.html.twig', array(
            'entrepot' => $entrepot,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Finds and displays a entrepot entity.
     *
     * @Route("entrepot/{idEntrepot}", name="entrepot_show")
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
     * @Route("entrepot/{idEntrepot}/delete", name="entrepot_delete")
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
