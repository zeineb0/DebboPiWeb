<?php


namespace RHBundle\Controller;
use RHBundle\Entity\Employe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MailController extends Controller
{
    public function sendmailAction(Request $request){
        return $this->render('@RH/mail/sendmail.html.twig'
        );
    }

}