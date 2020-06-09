<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntrepotBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UtilisateurMobileController extends Controller
{
    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){
        $em=$this->getDoctrine()->getManager();
      //  $user = $this->userManager->createUser();
        $user = new User();
        $user->setEnabled(1);
        $user->setUsername($request->get('username'));
        //$user->setUsernameCanonical($request->get('username'));
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setEmail($request->get('email'));
     // $user->setEmailCanonical($request->get('email'));
        $user->setPlainPassword($request->get('password'));
        $user->setRoles(array('ROLE_USER'));
        $user->setCin($request->get('cin'));
        $user->setTel($request->get('tel'));

    //    $this->userManager->updateUser($user);

        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($user);
        return new JsonResponse($formated);
    }

    public function changeUsernameAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($request->get('id'));
        $user->setUsername($request->get('username'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($user);
        return new JsonResponse($formated);
    }

    public function changeEmailAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($request->get('id'));
        $user->setEmail($request->get('email'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($user);
        return new JsonResponse($formated);
    }

    public function changePasswordAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($request->get('id'));
       // $user->setPlainPassword($request->get('password'));
        $user->setPassword($this->container->get('security.encoder_factory')->getEncoder($user)->encodePassword($request->get('password'), $user->getSalt()));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($user);
        return new JsonResponse($formated);
    }

    public function changeTelAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($request->get('id'));
        $user->setTel($request->get('tel'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($user);
        return new JsonResponse($formated);
    }


    public function plainPWAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($request->get('id'));
        $user->getPlainPassword();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($user);
        return new JsonResponse($formated);
    }


}