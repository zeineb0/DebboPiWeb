<?php


namespace RHBundle\Controller;


use RHBundle\Entity\conge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class apiController extends Controller
{

    public function allAction(){
        $conge=$this->getDoctrine()->getManager()->getRepository('RHBundle:conge')->findAll();
       /* $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted =$serializer->normalize($conge);*/

        foreach($conge as $item) {

            $arrayCollection[] = array(
                'dateArrive' => date_format($item->getDatearrive(), 'd/m/y'),
                'id'=>$item->getId()

            );
        }
        return new JsonResponse($arrayCollection);
}
    public function newAction(Request $request)
    {
        $conge = new conge();
        // $c->getId()->setId($request->get('id'));
        //$conge->setId($request->get('id'));
        $datee=$request->get('datearrive');
        $dateM = new \DateTime($datee);
        $conge->setDatearrive($dateM);
        $datee=$request->get('datesortie');
        $dateM1 = new \DateTime($datee);
        $conge->setDatesortie($dateM1);
        $conge->setEtat($request->get('etat'));
        $conge->setType($request->get('type'));
        $conge->setFKIdEmp($request->get('FKIdEmp'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($conge);
        $em->flush();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($conge, 'json');
        return new Response($jsonContent);


    }

}