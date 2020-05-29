<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\Commande;
use CommandeBundle\Entity\ProduitCommande;
use NotificationBundle\Controller\BlogController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/Mobile")
 */
class CommandeJsonController extends Controller
{
    /**
     * @Route("/commande/")
     * @Method("GET")
     */
    public function afficheCommandeAction(Request $request)
    {
            $em = $this->getDoctrine()->getManager();
            $commandes = $em->getRepository('CommandeBundle:Commande')->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($commandes, 'json');
        return new Response($jsonContent);
    }

    /**
     * @Route("/newCommande")
     * @Method("GET")
     */
    public function newCommandeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EntrepotBundle:Utilisateur')->find($request->get('idU'));
        $date = new \DateTime('now');
        $commande = new Commande();
        $commande->setTypePaiement('carte');
        $commande->setDateCommande(new \DateTime('now'));
        $commande->setTotal($request->get('total'));
        $commande->setDateExp($date->add(new \DateInterval('P30D')));
        $commande->setIdClient($user);
        $em->persist($commande);
        $em->flush();
        $produits = $request->get('produits');
            $d=0;  $ch="";

        while(strlen($produits)!=0) {

            if ($produits[0] == "-") {

                if (!$d) {
                    $prd = $ch;
                    $d = 1;
                } elseif ($d == 1) {
                    $qtt = $ch;
                    $d = 2;
                }
                $ch = "";
                $produits=substr($produits,1);
            }
            elseif ($produits[0] == "_"){
                $prix = $ch;
                $d = 0;
                $produit = $em->getRepository('EntrepotBundle:Produit')->findOneBy(array('idProduit'=>floatval($prd)));
                $produitCommande = new ProduitCommande();
                $produitCommande->setIdCommande($commande);
                $produitCommande->setIdProduit($produit);
                $produitCommande->setQuantiteProduit(floatval($qtt));
                $produitCommande->setPrixProduit(floatval($prix));
                $em->persist($produitCommande);
                $em->flush();
                $em=$this->getDoctrine()->getManager()->createQuery('update EntrepotBundle:Produit p 
                set p.quantite = p.quantite-?0 where p.idProduit=?1
                ')->setParameter(0,floatval($qtt))->setParameter(1,floatval($prd))->execute();
                $em = $this->getDoctrine()->getManager();
                $ch="";
                $produits=substr($produits,1);
            }
            else {
                $ch=$ch.$produits[0];
                $produits=substr($produits,1);
            }

        }
                BlogController::newAction($user,$em);
               $encoders = [new XmlEncoder(), new JsonEncoder()];
               $normalizers = [new ObjectNormalizer()];
               $serializer = new Serializer($normalizers, $encoders);
               $jsonContent = $serializer->serialize(200, 'json');
               return new Response($jsonContent);




    }



    /**
     * @Route("/commande/{idCommande}/")
     * @Method("GET")
     */
    public function showCommandeAction($idCommande)
    {    $em=$this->getDoctrine()->getManager() ;
        $commande = $em->createQuery(' 
        select c.total,c.dateCommande,c.dateExp,  p.prixProduit,p.quantiteProduit,i.marque,i.reference    
            from CommandeBundle:Commande c
              left join  CommandeBundle:ProduitCommande p with (c.idCommande =?0  and c.idCommande=p.idCommande)
              inner join   EntrepotBundle:Produit i  with i.idProduit=p.idProduit 
         ' )
            ->setParameter(0,$idCommande)
            ->getResult();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($commande, 'json');
        return new Response($jsonContent);
    }



    public function deleteCommandeAction( $idCommande)
    {
        $form = $this->getDoctrine()->getRepository(Commande::class)->findBy(array("idCommande"=>$idCommande));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

        return $this->redirectToRoute('commande_index');
    }


        /*********************************  Notification *************************************/
    /**
     * @Route("/notification/")
     * @Method("GET")
     */
    public function notifAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->createQuery(
            'select n.id id,n.date date,b.title title, b.description description, b.auteur auteur
            from NotificationBundle:Notification n inner join 
         NotificationBundle:Blog  b  where (b.id = n.parameters) order by date desc'
        )->getResult();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($blogs, 'json');
        return new Response($jsonContent);
    }

    /*********************************  Produit *************************************/
    /**
     * @Route("/allP")
     * @Method("GET")
     */
    public function allPAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EntrepotBundle:Produit')->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($categories, 'json');
        echo $jsonContent;
        return new Response($jsonContent);
    }

}

