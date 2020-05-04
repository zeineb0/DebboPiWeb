<?php

namespace AppBundle\Controller;


use NotificationBundle\Controller\BlogController;
use NotificationBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EntrepotBundle\Entity\Produit;

class DefaultController extends Controller
{

    /**
     *
     * @Route("produit", name="produit_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository(Produit::class)->findAll();
        return $this->render('@Commande/commande/produit.html.twig', array(
            'produits'=>$produits,
        ));

    }

    /**
     *
     * @Route( "" , name="user_Check")

     */
    public function userCheckAction()
    { $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
            if( $securityContext->isGranted('ROLE_ADMIN')){
            return $this->render('admin.html.twig', array(

            ));}
            else if( $securityContext->isGranted('ROLE_USER'))
            {if( $securityContext->isGranted('ROLE_CLIENT')) {
                return $this->redirectToRoute('commande_index');
            }
            else
            {
                return $this->render('base.html.twig', array(

            ));}
            }

        }
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
