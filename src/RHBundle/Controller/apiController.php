<?php


namespace RHBundle\Controller;


use RHBundle\Entity\conge;
use RHBundle\Entity\Employe;
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
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($conge, 'json');
        echo $jsonContent;
        return new Response($jsonContent);






        /* foreach($conge as $item) {

            $arrayCollection[] = array(
               $dateM = new \DateTime($item->getDatesortie()),
                $dateA = new \DateTime($item->getDatearrive()),
                'id'=>$item->getId(),
                'datearrive' => $item->getDatearrive(),
                'datesortie' => $item->getDatesortie(),
                'raison' =>$item->getRaison(),
                'type' => $item->getType(),
                'etat' => $item->getEtat(),
                'fkidemp' => $item->getFKIdEmp(),

            );
        }
        return new JsonResponse($arrayCollection);*/
}
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $emp = $em->getRepository('RHBundle:employe')->findOneBy(array('idEmp' => $request->get('FKIdEmp')));
        echo $emp->getNbcong().$emp->getIdEmp();
        $employe = new Employe();
        $employe->setIdEmp($emp->getIdEmp());
        $employe->setNbcong($emp->getNbcong());
        $conge = new conge();
        // $c->getId()->setId($request->get('id'));
        //$conge->setId($request->get('id'));
        $datee = $request->get('datearrive');
        $dateM = new \DateTime($datee);
        $conge->setDatearrive($dateM);
        $datee = $request->get('datesortie');
        $dateM1 = new \DateTime($datee);
        $conge->setDatesortie($dateM1);
        $conge->setEtat($request->get('etat'));
        $conge->setType($request->get('type'));
        $conge->setFKIdEmp($request->get('FKIdEmp'));
        $conge->setRaison($request->get('raison'));

        if ($emp->getNbcong() < 14) {
        // $idc=$request->get('FKIdEmp');
        //  $nbc=$this->getDoctrine()->getManager()->getRepository('RHBundle:employe')->findBy(['$idEmp' => $idc]);
        $em = $this->getDoctrine()->getManager();
        $em->persist($conge);
        $em->flush();
            $em->createQuery('update RHBundle:Employe e
                set e.nbcong = e.nbcong+?1 where e.idEmp=?0
                ')->setParameter(0,$request->get('FKIdEmp'))->setParameter(1,$request->get('d'))->execute();

        }
        $conge->setFKIdEmp($employe);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($conge, 'json');
        return new Response($jsonContent);
    }
    public function modifiercongeAction(Request $request){
        $em= $this->getDoctrine()->getManager();
        $conge=$em->getRepository('RHBundle:conge')->find($request->get('id'));
        $dates=$request->get('datesortie');
        $datess= new \DateTime($dates);
        $datea=$request->get('datearrive');
        $dateaa= new \DateTime($datea);
        $conge->setDatearrive($dateaa);
        $conge->setDatesortie($datess);
        $conge->setType($request->get('type'));
        $conge->setRaison($request->get('raison'));
        $em1=$this->getDoctrine()->getManager();
        $em1->persist($conge);
        $em1->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($conge, 'json');
        return new Response($jsonContent);
    }

}