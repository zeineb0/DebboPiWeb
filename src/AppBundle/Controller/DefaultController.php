<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use NotificationBundle\Controller\BlogController;
use NotificationBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use StockBundle\Entity\Produit;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)

    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('StockBundle:Produit')->findAll();
        $cat = $em->getRepository('StockBundle:Categories')->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'produits'=>$produits,
            'cat'=>$cat,


        ]);
    }


    /**
     *
     * @Route("Gproduit", name="Gproduit_index")
     */
    public function indexGAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository(Produit::class)->findAll();
        return $this->render('@Commande/commande/produit.html.twig', array(
            'produits'=>$produits,
        ));

    }

    /**
     *
     * @Route( "" , name="user_Check")

     */
    public function userCheckAction()
    { $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
            if( $securityContext->isGranted('ROLE_ADMIN')){
            return $this->render('admin.html.twig', array(

            ));}
            else if( $securityContext->isGranted('ROLE_USER'))
            {if( $securityContext->isGranted('ROLE_CLIENT')) {
                return $this->redirectToRoute('commande_index');
            }
            else
            {
                return $this->render('base.html.twig', array(

            ));}
            }

        }
        else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
    /**
     * @Route("/back", name="back")
     */
    public function backAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entrepots = $em->getRepository('GererEntrepotBundle:Entrepot')->findAll();
        $categories = $em->getRepository('StockBundle:Categories')->findAll();

        foreach($entrepots as $entrepot)
        {
            $ent = $em->createQuery('SELECT SUM(p.quantite) somme FROM StockBundle:Produit p WHERE p.fkEntrepot =:item ')
                ->setParameter('item',$entrepot)
                ->getResult();
        }

        foreach ($categories as $category){
            $categ = $em->createQuery('SELECT SUM(p.quantite) somme FROM StockBundle:Produit p WHERE p.fkCategorie =:item ')
                ->setParameter('item',$category)
                ->getResult(); }


        $nbU=$em->createQuery('SELECT COUNT(u) nombre FROM AppBundle:User u')
            ->getResult();

        $nbP=$em->createQuery('SELECT COUNT(p) nombre FROM StockBundle:Produit p')
            ->getResult();
        $nbCA=$em->createQuery('SELECT COUNT(c) nombre FROM StockBundle:Categories c')
            ->getResult();

        $nbF=$em->createQuery('SELECT COUNT(u) nombre FROM AppBundle:User u WHERE u.role= ?0 ')
            ->setParameter(0,'proprietaire')
            ->getResult();

        $nbC=$em->createQuery('SELECT COUNT(u) nombre FROM AppBundle:User u WHERE u.role= ?0 ')
            ->setParameter(0,'client')
            ->getResult();
        $nbM=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m')
            ->getResult();

        $nbME=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 ')
            ->setParameter(0,'Entrée')
            ->getResult();

        $nbMS=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 ')
            ->setParameter(0,'Sortie')
            ->getResult();


        return $this->render('baseBack.html.twig', array(
            'ent'=>$entrepots,
            'categ'=>$categories,
            'nbU'=>$nbU,
            'nbCA'=>$nbCA,
            'nbM'=>$nbM,
            'nbF'=>$nbF,
            'nbC'=>$nbC,
            'nbP'=>$nbP,
            'nbME'=>$nbME,
            'nbMS'=>$nbMS,
        ));

    }
    /**
     * @Route("/front", name="front")
     */
    public function frontAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('StockBundle:Produit')->findAll();

        // replace this example code with whatever you need
        return $this->render('accueil.html.twig',array('produits'=>$produits));
    } /**
     * @Route("/frontF", name="frontF")
     */
    public function frontFAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('StockBundle:Produit')->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $username=$this->getUser()->getUsername();
        $produits = $em->getRepository('StockBundle:Produit')->findAll();
        $cat = $em->getRepository('StockBundle:Categories')->findAll();

        $nbME=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 AND m.idUser= ?1 ')
            ->setParameter(0,'Entrée')
            ->setParameter(1,$user)
            ->getResult();

        $nbC=$em->createQuery('SELECT COUNT(c) nombre FROM StockBundle:Categories c WHERE c.idUser= ?0 ')
            ->setParameter(0,$user)
            ->getResult();
        $nbE=$em->createQuery('SELECT COUNT(e) nombre FROM GererEntrepotBundle:Entrepot e WHERE e.id= ?0 ')
            ->setParameter(0,$user)
            ->getResult();

        $nbP=$em->createQuery('SELECT COUNT(p) nombre FROM StockBundle:Produit p WHERE p.idUser= ?0 ')
            ->setParameter(0,$user)
            ->getResult();

        $nbMS=$em->createQuery('SELECT COUNT(m) nombre FROM StockBundle:MouvementDuStock m WHERE m.natureMouvement= ?0 AND m.idUser= ?1 ')
            ->setParameter(0,'Sortie')
            ->setParameter(1,$user)
            ->getResult();
        // replace this example code with whatever you need
        return $this->render('base.html.twig',array('produits'=>$produits,
             'nbME'=>$nbME,
            'nbMS'=>$nbMS,
            'nbC'=>$nbC,
            'nbE'=>$nbE,
            'nbP'=>$nbP,
            'username'=>$username,
        ));
    }


}
