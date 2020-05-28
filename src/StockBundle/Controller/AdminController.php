<?php


namespace StockBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use StockBundle\Entity\Categories;
use StockBundle\Entity\Produit;
use AppBundle\Entity\User;

class AdminController extends Controller
{

    public function accAction(){
        $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->findAll();
        $categories = $em->getRepository('StockBundle:Categories')->findAll();

       foreach($entrepots as $entrepot){
        $ent = $em->createQuery('SELECT SUM(p.quantite) somme FROM StockBundle:Produit p WHERE p.fkEntrepot =:item ')
            ->setParameter('item',$entrepot)
            ->getResult(); }
        foreach ($categories as $category){
        $categ = $em->createQuery('SELECT SUM(p.quantite) somme FROM StockBundle:Produit p WHERE p.fkCategorie =:item ')
            ->setParameter('item',$category)
            ->getResult(); }


        $nbU=$em->createQuery('SELECT COUNT(u) FROM AppBundle:User u')
            ->getResult();

        $nbF=$em->createQuery('SELECT COUNT(u) FROM AppBundle:User u WHERE u.role= ?0 ')
            ->setParameter(0,'proprietaire')
            ->getResult();

        $nbC=$em->createQuery('SELECT COUNT(u) FROM AppBundle:User u WHERE u.role= ?0 ')
            ->setParameter(0,'client')
            ->getResult();

        $nbME=$em->createQuery('SELECT COUNT(m) FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 ')
            ->setParameter(0,'Entrée')
            ->getResult();

        $nbMS=$em->createQuery('SELECT COUNT(m) FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 ')
            ->setParameter(0,'Sortie')
            ->getResult();


        return $this->render('@Stock/user/accueil.html.twig', array(
            'ent'=>$ent,
            'categ'=>$categ,
            'nbU'=>$nbU,
            'nbF'=>$nbF,
            'nbC'=>$nbC,
            'nbME'=>$nbME,
            'nbMS'=>$nbMS,
        ));
    }

    public function userAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('@Stock/user/ListUsers.html.twig', array(
            'user'=>$users,
        ));

    }


    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StockBundle:Categories')->findAll();

        return $this->render('@Stock/user/categorieliste.html.twig', array(
            'categories' => $categories,
        ));
    }
    public function produitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('StockBundle:Produit')->findAll();
        return $this->render('@Stock/user/produit.html.twig', array(
            'produits' => $produits,
        ));
    }

    public  function statCAction()
    {
        return $this->render('@Stock/user/statcateg.html.twig');

    }

}