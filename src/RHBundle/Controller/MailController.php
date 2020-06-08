<?php


namespace RHBundle\Controller;
use RHBundle\Entity\Employe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MailController extends Controller
{
    public function sendmailAction(Request $request){
        $email=$request->get('email');
        $username='debbopi@gmail.com';
        $message = \Swift_Message::newInstance()
            ->setSubject('Information')
            ->setFrom($username)
            ->setTo($email)
            ->setBody($this->renderView(
                    '@RH/mail/sendmail.html.twig'
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        return $this->redirectToRoute('employe_index');
    }

}