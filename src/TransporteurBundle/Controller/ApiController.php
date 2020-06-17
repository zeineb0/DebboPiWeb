<?php

namespace TransporteurBundle\Controller;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TransporteurBundle\Entity\Contrat;
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


    // Contrat Actions :


    public function getContratAction($id)
    {
        $contrat = $this->getDoctrine()->getRepository(Contrat::class)->getContratByProp($id);

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($contrat);
        return new JsonResponse($formatted);


    }


    public function getContratEXPAction($id)
    {
        $contrat = $this->getDoctrine()->getRepository(Contrat::class)->getListContratExp($id);

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($contrat);
        return new JsonResponse($formatted);


    }

    public function supprimerContratAction(Request $request)
    {

        $id_transporteur=$request->get("id_transporteur");
        $id_entrepot=$request->get("id_entrepot");

        $em=$this->getDoctrine()->getManager() ;
        $em->createQuery('delete from TransporteurBundle:Contrat c where c.FKidentrepot=?0 and c.FKiduser=?1')
            ->setParameters(array(0=>$id_entrepot,1=>$id_transporteur))
            ->execute();

        return $this->getContratAction(2);


    }
    public function getEntrepotAction()
    {
        $entrepot = $this->getDoctrine()->getRepository('EntrepotBundle:Entrepot')->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($entrepot);
        return new JsonResponse($formatted);
    }






}