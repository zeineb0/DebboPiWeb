<?php

namespace TransporteurBundle\Controller;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TransporteurBundle\Entity\Livraison;


class ApiController extends Controller
{
    public function getLivParTransporteurDAction($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserD($id);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($livraison);
        return new JsonResponse($formatted);

    }

    public function getLivParTransporteurNDAction($id)
    {
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->getLivraisonByUserNotD($id);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($livraison);
        return new JsonResponse($formatted);

    }


    public function supprimerLivraisonAction($idliv)
    {
        $em=$this->getDoctrine()->getManager() ;
        $em->createQuery('delete from TransporteurBundle:Livraison l where l.idLivraison=?0')
            ->setParameter(0,$idliv)
            ->execute();

        return $this->getLivParTransporteurDAction(1);

    }

    public function modifierLivraisonAction(Request $request)
    {

        $datee=$request->get("date");
        $dateL = new \DateTime($datee);

        $id_liv=$request->get("id_liv");

        $em=$this->getDoctrine()->getManager() ;
        $em->createQuery("Update TransporteurBundle:Livraison l SET l.dateLivraison=?1 where l.idLivraison=?2")
            ->setParameters(array(1=>$dateL,2=>$id_liv))
            ->execute();

        return $this->getLivParTransporteurDAction($request->get("id_user"));

    }


}