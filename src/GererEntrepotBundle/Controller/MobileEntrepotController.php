<?php

namespace GererEntrepotBundle\Controller;

use AppBundle\Entity\User;
use GererEntrepotBundle\Entity\Entrepot;
use GererEntrepotBundle\Entity\Location;
use GererEntrepotBundle\GererEntrepotBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * MobileEntrepot controller.
 *
 * @Route("/")
 */
class MobileEntrepotController extends Controller
{
    //******************************************Entrepot************************//

    // affichage les depot à louer
    /**
     *
     * @Route("entrepotM/alouer", name="entrepotM_a_louer")
     */
    public function aLouerAction(Request $request)
    {

        $entrepots= $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
            ->findBy(array('etat' => ['A Louer', 'En Attente']));
        $demandes =$this->getDoctrine()->getManager()->getRepository(Location::class)->findBy(array('fkEntrepot'=>$entrepots,'fkUser'=>$request->get('idUser')));
        $i=0;
        $ent [] = new Entrepot();
        foreach($entrepots as $entrepot)
        {$test=false;
            if($entrepot->getId()->getId()==$request->get('idUser')) {
                $test=true;
            }
            else
            {
                foreach ($demandes as $demande)
                {
                    if ($demande->getfkEntrepot()->getIdEntrepot() ==$entrepot->getIdEntrepot())
                    {$test=true;
                    }

                }
            }
            if($test==false)
            {$ent[$i]=$entrepot;
                $i++;
            }

        }
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($ent, 'json');
        return new Response($jsonContent);

    }



    /**
     * afficher entrepots loués.
     * @Route("entrepotM/loue", name="entrepotM_loue")
     */
    public function entrepotLouéAction( Request $request)
    {
        $entrepots = $this->getDoctrine()->getManager()->getRepository(Entrepot::class)
            ->findBy(array('id' => $request->get('idUser'),'etat' => 'Loué'));

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepots, 'json');
        return new Response($jsonContent);

    }


    /**
     * Lists all entrepot entities.
     *
     * @Route("entrepotM/", name="entrepotM_index")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findBy(array('id' => $request->get('idUser')));


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepots, 'json');
        return new Response($jsonContent);


    }


    /**
     * Creates a new entrepot entity.
     *
     * @Route("entrepotM/new", name="entrepotM_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $entrepot = new Entrepot();
        $user =$this->getDoctrine()->getManager()->getRepository('AppBundle:User')
            ->find($request->get('id'));

        $entrepot->setId($user);
        $entrepot->setAdresse($request->get('adresse'));
        $entrepot->setQuantiteMax($request->get('quantiteMax'));
        $entrepot->setNumFiscale($request->get('numFiscale'));

        $entrepot->setEntreprise($request->get('entreprise'));
        $entrepot->setEtat($request->get('etat'));

        $entrepot->setPrixLocation($request->get('prixLocation'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($entrepot);
        $em->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepot, 'json');
        return new Response($jsonContent);

    }



    /**
     * Displays a form to edit an existing entrepot entity.
     *
     * @Route("entrepotM/{idEntrepot}/edit", name="entrepotM_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $idEntrepot)
    {  $em = $this->getDoctrine()->getManager();
        $entrepot = $em->getRepository('GererEntrepotBundle:Entrepot')->findOneBy(array('idEntrepot'=>$idEntrepot));

        $entrepot->setEtat($request->get('etat'));

        $entrepot->setPrixLocation($request->get('prixLocation'));
        $entrepot->setEntreprise($request->get('entreprise'));

        $em1 = $this->getDoctrine()->getManager();
        $em1->persist($entrepot);
        $em1->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepot, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
    }




    /**
     * Finds and displays a entrepot entity.
     *
     * @Route("entrepotM/{idEntrepot}", name="entrepotM_show")
     * @Method("GET")
     */
    public function showAction($idEntrepot)
    {
        $em = $this->getDoctrine()->getManager();
        $entrepot = $em->getRepository('GererEntrepotBundle:Entrepot')->findOneBy(array('idEntrepot'=>$idEntrepot));


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entrepot, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
    }

    /**
     * Deletes a entrepot entity.
     *
     * @Route("entrepotM/{idEntrepot}/delete", name="entrepotM_delete")
     * @Method("DELETE")
     */
    public function deleteAction( $idEntrepot)
    {
        $form = $this->getDoctrine()->getRepository(Entrepot::class)->findOneBy(array("idEntrepot"=>$idEntrepot));
        $em=$this->getDoctrine()->getManager();
        $em->remove($form);
        $em->flush();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize(200, 'json');
        return new Response($jsonContent);
    }


////*************Location*********//
    /**
     * Lists all location entities.
     *
     * @Route("locationM/", name="locationM_index")
     * @Method("GET")
     */
    public function indexLAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('GererEntrepotBundle:Location')->findBy(array('fkUser'=>$request->get('idUser')));

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($locations, 'json');
        echo $jsonContent;
        return new Response($jsonContent);

    }
    /**
     * @Route("/locationM/{id}/pdf", name="locationM_pdf")
     */
    public function pdfAction($id)
    {
        $snappy = $this->get('knp_snappy.pdf');


        $em = $this->getDoctrine()->getManager();

        /* @var Location $location */
        $location = $em->getRepository(Location::class)->find($id);
        $s=$location->getFkEntrepot();
        $entrepot = $em->getRepository(Entrepot::class)->findBy(['idEntrepot' => $s]);


        $html = $this->renderView('@GererEntrepot/location/Pdf.html.twig',
            array(
                'entrepot' => $entrepot,
                'location' => $location,
            ));

        $filename = 'myFirstSnappyPDF';
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );

    }



    public function confirmationAction(Location $location){

        $em = $this->getDoctrine()->getManager();
        $em->persist($location);
        $em->flush();
        $entrepot=$em->getRepository('GererEntrepotBundle:Entrepot')->findOneBy(array('idEntrepot'=>$location->getFkEntrepot()));
        $entrepot->setEtat('En Attente');
        $em->persist($entrepot);
        $em->flush();
        return $this->json($location->getFkEntrepot()->getIdEntrepot());

    }

    /**
     * @Route("locationM/confirmer", name="locationM_accepter")
     */
    public function confirmerAction(){
        return $this->render('@GererEntrepot/location/test.html.twig');
    }
    /**
     * Creates a new location entity.
     *
     * @Route("locationM/new/{idEntrepot}", name="locationM_new")
     * @Method({"GET", "POST"})
     */
    public function newLAction( $idEntrepot,Request $request)
    {
        $location = new Location();

        $location->setFkUser($request->get('id'));
        $location->setFkEntrepot($idEntrepot);
        $datedeb=$request->get('dateDebLocation');
        $datede = new \DateTime($datedeb);
        $datefin=$request->get('dateFinLocation');
        $datefi = new \DateTime($datefin);

        $location->setDateDebLocation($datede);
        $location->setDateFinLocation($datefi);

        $location->setPrixLocation($request->get('prixLocation'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($location,'json');
        echo $jsonContent;
        return new Response($jsonContent);


    }


    /**
     * Finds and displays a location entity.
     *
     * @Route("locationM/{idLocation}", name="locationM_show")
     * @Method("GET")
     */
    public function showLAction(Location $location)
    {

    }

    /**
     * Displays a form to edit an existing location entity.
     *
     * @Route("locationM/{idLocation}/edit", name="locationM_edit")
     * @Method({"GET", "POST"})
     */
    public function editLAction(Request $request, Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);
        $editForm = $this->createForm('GererEntrepotBundle\Form\LocationType', $location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $prix=$location->getFkEntrepot()->getPrixLocation();
            $datDeb = new \DateTime($location->getDateDebLocation()->format('Y/m/d'));
            $datFin = new \DateTime($location->getDateFinLocation()->format('Y/m/d'));

            $location->setPrixLocation(($datFin->diff($datDeb)->days)*($prix/30));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('locationM_show', array('idLocation' => $location->getIdlocation()));
        }

        return $this->render('@GererEntrepot/location/edit.html.twig', array(
            'location' => $location,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a location entity.
     *
     * @Route("locationM/{idLocation}/delete", name="locationM_delete")
     * @Method("DELETE")
     */
    public function deleteLAction( $idLocation)
    {
        $form = $this->getDoctrine()->getRepository(Location::class)->findBy(array("idLocation"=>$idLocation));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize(200, 'json');
        return new Response($jsonContent);
    }


}
