<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
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
