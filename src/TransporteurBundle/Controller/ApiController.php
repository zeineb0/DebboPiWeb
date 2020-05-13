<?php

namespace TransporteurBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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


}