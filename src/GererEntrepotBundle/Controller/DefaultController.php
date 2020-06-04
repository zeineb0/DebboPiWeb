<?php

namespace GererEntrepotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAdminAction()
    {

        return $this->render('admin_home.html.twig',array('notifications' => $notif));
    }
}
