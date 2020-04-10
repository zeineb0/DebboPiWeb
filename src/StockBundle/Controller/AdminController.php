<?php


namespace StockBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use StockBundle\Entity\Categories;
use StockBundle\Entity\Produit;
use AppBundle\Entity\User;

class AdminController extends Controller
{

    public function userAction(){
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

}