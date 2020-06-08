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

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();
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
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StockBundle:Categories')->findAll();
        $i=-1; $tab= array();
        $nbCA=$em->createQuery('SELECT COUNT(c) nombre FROM StockBundle:Categories c')
            ->getResult();
        foreach ($categories as $categorie){
            $i++;
            $tab[$i] = array('categorie'=>$categorie,'qtt'=>$em->createQuery('SELECT COUNT(p) somme FROM StockBundle:Produit p WHERE p.fkCategorie =:item ')
                ->setParameter('item',$categorie)
                ->getResult());
        }
        return $this->render('@Stock/user/statcateg.html.twig', array(
            'tab' => $tab,
            'categories'=>$categories,
            'nbCA'=>$nbCA,
            ));

    }
    public function statUAction(){
        $em = $this->getDoctrine()->getManager();
        $nbU=$em->createQuery('SELECT COUNT(u) nombre FROM AppBundle:User u')
            ->getResult();

        $nbF=$em->createQuery('SELECT COUNT(u) nombre FROM AppBundle:User u WHERE u.role= ?0 ')
            ->setParameter(0,'proprietaire')
            ->getResult();

        $nbC=$em->createQuery('SELECT COUNT(u) nombre FROM AppBundle:User u WHERE u.role= ?0 ')
            ->setParameter(0,'client')
            ->getResult();

        return $this->render('@Stock/user/statU.html.twig', array(
            'nbU'=>$nbU,
            'nbF'=>$nbF,
            'nbC'=>$nbC,


        ));}
        public function statMAction()
        {
            $em = $this->getDoctrine()->getManager();

            $nbME=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 ')
                ->setParameter(0,'Entrée')
                ->getResult();

            $nbMS=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 ')
                ->setParameter(0,'Sortie')
                ->getResult();
            $nbM=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m')
                ->getResult();

            return $this->render('@Stock/user/statM.html.twig', array(
                'nbM'=>$nbM,
                'nbME'=>$nbME,
                'nbMS'=>$nbMS,


            ));
    }
    public function statPAction(){
        $em = $this->getDoctrine()->getManager();

        $nbP=$em->createQuery('SELECT COUNT(p) nombre FROM StockBundle:Produit p')
            ->getResult();
        $entrepots = $em->getRepository('EntrepotBundle:Entrepot')->findAll();

        $i=-1; $tab= array();
        $nbCA=$em->createQuery('SELECT COUNT(c) nombre FROM StockBundle:Categories c')
            ->getResult();
        foreach ($entrepots as $entrepot){
            $i++;
            $tab[$i] = array('entrepot'=>$entrepot,'qtt'=>$em->createQuery('SELECT COUNT(p) somme FROM StockBundle:Produit p WHERE p.fkEntrepot =:item ')
                ->setParameter('item',$entrepot)
                ->getResult());
        }
        return $this->render('@Stock/user/statP.html.twig', array(
            'nbP'=>$nbP,
            'tab' => $tab,
            'entrepots'=>$entrepots,


        ));
    }

}