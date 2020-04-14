<?php


namespace RHBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MailController extends Controller
{
    public function sendmail(Request $request){
        return $this->redirectToRoute('send_mail');

        return $this->render('@RH/Mail/sendmail.html.twig'
        );

    }

}