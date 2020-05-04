<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/home")
     */
    public function redirectAction()
    {
        $authCheker = $this->container->get('security.authorization_checker');

        if($authCheker ->isGranted('ROLE_SUPER_ADMIN'))
        {
            return $this->redirectToRoute('admin_page');

        } else if ($authCheker ->isGranted('ROLE_ENTREPOT'))
        {
            //return $this->render('@App/Security/Entrepot_home.html.twig');
            return $this->redirectToRoute('afficher_contrat');

        } else if ($authCheker ->isGranted('ROLE_TRANSPORTEUR'))
        {
           // return $this->render('@App/Security/Transporteur_home.html.twig');
            return $this->redirectToRoute('livraison_calendar');

        } else if ($authCheker ->isGranted('ROLE_CLIENT'))
        {
            return $this->render('@App/Security/Client_home.html.twig');
        }

        else
        {
            return $this->render('@FOSUserBundle/Security/login.html.twig');
        }
    }

}
