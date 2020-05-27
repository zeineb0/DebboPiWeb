<?php


namespace StockBundle\Controller;


use StockBundle\Entity\Categories;
use StockBundle\Entity\MouvementDuStock;
use StockBundle\Entity\Produit;
use EntrepotBundle\Entity\Entrepot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class JsonController extends Controller
{
    //***************************catégorie**************************************
    public function allCAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $categories = $em->getRepository('StockBundle:Categories')->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($categories, 'json');
        echo $jsonContent;
        return new Response($jsonContent);

    }
    public function ajouterCAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $categories = new Categories();
        //  $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $categories->setNom($request->get('nom'));
        $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->find($request->get('fkEntrepot'));
        $categories->setFkEntrepot($entrepots);
        $categories->setIdUser($request->get('idUser'));
        // $categories->setIdUser($user);
        $categories->setImageName('covered_with_a_veil-wallpaper-1920x1080.jpg'
        );
        $em->persist($categories);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categories);
        return new JsonResponse($formatted);

    }
    public function modifierCAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('StockBundle:Categories')->find($request->get('idCategorie'));

        if ($request->get('nom')!=null ){
            $categorie->setNom($request->get('nom'));}

        if ($request->get('fkEntrepot')!=null){
            $ent = $em->getRepository('EntrepotBundle:Entrepot')->find($request->get('fkEntrepot'));
            $categorie->setFkEntrepot($ent);

        }

        $em->persist($categorie);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
    }
    public function deleteCAction(Request $request){


        $categorie= $this->getDoctrine()->getRepository(Categories::class)->find($request->get('idCategorie'));
        $em=$this->getDoctrine()->getManager();

        $em->remove($categorie);

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
    }

    //***********************************entrepot**********************************
    public function allEAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EntrepotBundle:Entrepot')->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($categories, 'json');
        echo $jsonContent;
        return new Response($jsonContent);

    }
    //***********************************produit***********************************
    public function allPAction(){

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StockBundle:Produit')->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($categories, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
    }
    public function ajouterPAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $produit->setLibelle($request->get('libelle'));
        $produit->setMarque($request->get('marque'));
        $produit->setPrix($request->get('prix'));
        $produit->setFkEntrepot($request->get('fkEntrepot'));
        $produit->setReference($request->get('reference'));
        $produit->setImageName('covered_with_a_veil-wallpaper-1920x1080.jpg');
        $produit->setQuantite($request->get('quantite'));
        $produit->setPromotion(0);
        $produit->setIdUser($request->get('idUser'));
        $categories = $em->getRepository('StockBundle:Categories')->find($request->get('fkCategorie'));
        $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->find($request->get('fkEntrepot'));
        $ent=$categories->getFkEntrepot();
        $produit->setFkCategorie($categories);
        $produit->setFkEntrepot($ent);
        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);

    }
    public function modifierPAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('StockBundle:Produit')->find($request->get('idProduit'));

            if ($request->get('libelle')!=null ){
            $produit->setLibelle($request->get('libelle'));}

                if($request->get('marque') !=null){
                    $produit->setMarque($request->get('marque'));

                }

                if($request->get('prix') !=null){
                    $produit->setPrix($request->get('prix'));

                }
                if($request->get('reference') !=null){
                    $produit->setReference($request->get('reference'));

                }
                if($request->get('quantite') !=null){
                    $produit->setQuantite($request->get('quantite'));

                }
                if ($request->get('fkEntrepot')!=null){
                    $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->find($request->get('fkEntrepot'));
                    $produit->setFkEntrepot($entrepots);

                }
                if ($request->get('fkCategorie')!=null){
                    $categories = $em->getRepository('StockBundle:Categories')->find($request->get('fkCategorie'));
                    $produit->setFkCategorie($categories);

                }

        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);

    }
    public function deletePAction(Request $request){


        $produit= $this->getDoctrine()->getRepository(Produit::class)->find($request->get('idProduit'));
        $em=$this->getDoctrine()->getManager();

        $em->remove($produit);

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    //*********************************mvt***********************************

    public function allMAction(){

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StockBundle:MouvementDuStock')->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($categories, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
    }
    public function ajouterMAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $mvt= new MouvementDuStock();

        $datee=$request->get('dateMouv');
       $dateM = new \DateTime($datee);

       $qte=($request->get('qte'));
       echo($qte);

        $produit = $em->getRepository('StockBundle:Produit')->find($request->get('fkProduit'));
        //$fk=$produit->getIdProduit();
        //var_dump($produit);
        //var_dump($fk);

        $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->find($request->get('fkEntrepot'));

        $mvt->setNatureMouvement($request->get('natureMouvement'));
        $mvt->setDateMouv($dateM);
        $mvt->setFkEntrepot($entrepots);
        $mvt->setFkProduit($produit);
        $em->persist($mvt);
        $em->flush();
        $id=$mvt->getFkProduit();
        $fk=$id->getIdProduit();
        if ($mvt->getNatureMouvement()=='Sortie') {
            if ($id->getQuantite() < $qte)

            {
                return new Response("qte");
            }
            else {

                $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                $update=$rrepo->updateProduitS($mvt,$qte,$fk);
            }
        }

        else
        {
            $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
            $update=$rrepo->updateProduitE($mvt,$qte,$fk);
        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($mvt);
        return new JsonResponse($formatted);

    }

    public function modifierMAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $mvt = $em->getRepository('StockBundle:MouvementDuStock')->find($request->get('idMouv'));

        if ($request->get('natureMouvement')!=null ){
            $mvt->setNatureMouvement($request->get('natureMouvement'));}

        if($request->get('dateMouv') !=null){

            $datee=$request->get('dateMouv');
            $dateM = new \DateTime($datee);
            $mvt->setDateMouv($dateM);

        }

        if($request->get('qte') !=null){
            $qte=$request->get('qte');
            echo $qte;
            $id=$mvt->getFkProduit();
            var_dump($id);
            $fk=$id->getIdProduit();
            echo $fk;
            if ($mvt->getNatureMouvement()=='Sortie') {
                if ($id->getQuantite() < $qte)

                {
                    return new Response("qte");
                }
                else {

                    $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                    $update=$rrepo->updateProduitS($mvt,$qte,$fk);
                }
            }

            else
            {
                $rrepo=$this->getDoctrine()->getManager()->getRepository('StockBundle:MouvementDuStock');
                $update=$rrepo->updateProduitE($mvt,$qte,$fk);
            }
        }

        if ($request->get('fkEntrepot')!=null){
            $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->find($request->get('fkEntrepot'));
            $mvt->setFkEntrepot($entrepots);

        }
        if ($request->get('fkProduit')!=null){
            $categories = $em->getRepository('StockBundle:Produit')->find($request->get('fkProduit'));
            $mvt->setFkProduit($categories);

        }

        $em->persist($mvt);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($mvt);
        return new JsonResponse($formatted);


    }

    public function deleteMAction(Request $request){


        $categorie= $this->getDoctrine()->getRepository(MouvementDuStock::class)->find($request->get('idMouv'));
        $em=$this->getDoctrine()->getManager();

        $em->remove($categorie);

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
    }

}