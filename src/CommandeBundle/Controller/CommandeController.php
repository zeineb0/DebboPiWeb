<?php

namespace CommandeBundle\Controller;

use CommandeBundle\CommandeBundle;
use CommandeBundle\Entity\Commande;
use CommandeBundle\Entity\ProduitCommande;
use EntrepotBundle\Entity\Produit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 * @Route("")
 */
class CommandeController extends Controller
{

    /**
     * Lists all commande entities.
     *
     * @Route("/commande/", name="commande_index")
     * @Method("GET")
     */
    public function indexAction()
    { $securityContext = $this->container->get('security.authorization_checker');
        if ( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $commandes = $em->getRepository('CommandeBundle:Commande')->findBy(array('idClient'=>$user));

        return $this->render('@Commande/commande/index.html.twig', array(
            'commandes' => $commandes,
        ));}
    else
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    /**
     * @Route("/commande/{idCommande}/pdf", name="commande_pdf")
     */
    public function pdfAction($idCommande)
    {         $snappy = $this->get('knp_snappy.pdf');
        $commande=$this->getDoctrine()->getManager()->getRepository('CommandeBundle:Commande')
            ->findOneBy(array('idCommande' =>$idCommande));

        $listproduit=$this->createProduitCommandeForm($commande);

        $i=0;
        foreach($listproduit as $produitCommande){
            $produits[$i]=$this->createProduitForm($produitCommande);
            $i++;
        }


        // use absolute path !
        $html = $this->renderView('@Commande/commande/pdf.html.twig', array(
            "title"=>"Awsome",
            'commande' => $commande,
            'listproduit' => $listproduit,
            'produits' =>$produits,

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

    /**
     * Lists all commande entities.
     *
     * @Route("/admin/commande", name="commande_admin")
     * @Method("GET")
     */
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('CommandeBundle:Commande')->findAll();

        return $this->render('@Commande/admin/commande.html.twig', array(
            'commandes' => $commandes,
        ));
    }
    /**
     * Creates a new commande entity.
     *
     * @Route("/commande/new", name="commande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
      $em=$this->getDoctrine()->getManager();
      $date=new \DateTime('now');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $commande= new Commande();
      $commande->setTypePaiement('carte');
      $commande->setDateCommande(new \DateTime('now'));
      $commande->setTotal($request->request->get('total'));}
      $commande->setDateExp($date->add(new \DateInterval('P30D')));
        $commande->setIdClient($user);
      $em->persist($commande);
      $em->flush();
       $produits= $request->request->get('commande');
      foreach ($produits as $produit){
          $produitCommande= new ProduitCommande();
          $produitCommande->setIdCommande($commande);
          $p= $this->getDoctrine()->getManager()->getRepository('EntrepotBundle:Produit')
              ->findOneBy(array('idProduit' => $produit['id']));
          $produitCommande->setIdProduit($p);
          $produitCommande->setQuantiteProduit(floatval($produit['quantity']));
          $produitCommande->setPrixProduit($produit['price']);
          $em->persist($produitCommande);
          $em->flush();
      }

        return $this->json([200,"succées"],200);


    }

       /**
     * Finds and displays a commande entity.
     *
     * @Route("/commande/{idCommande}", name="commande_show")
     * @Method("GET")
     */
    public function showAction($idCommande)
    {    $commande=$this->getDoctrine()->getManager()->getRepository('CommandeBundle:Commande')
        ->findOneBy(array('idCommande' =>$idCommande));

        $listproduit=$this->createProduitCommandeForm($commande);

        $i=0;
        foreach($listproduit as $produitCommande){
            $produits[$i]=$this->createProduitForm($produitCommande);
            $i++;
        }


        return $this->render('@Commande/commande/show.html.twig', array(
            'commande' => $commande,
            'listproduit' => $listproduit,
            'produits' =>$produits,

        ));


    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     * @Route("/commande/{idCommande}/edit", name="commande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commande $commande)
    {   $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('CommandeBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('idCommande' => $commande->getIdcommande()));
        }

        return $this->render('@Commande/commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     * @Route("/commande/{idCommande}/delete", name="commande_delete")
     * @Method("DELETE")
     */
    public function deleteAction( $idCommande)
    {
        $form = $this->getDoctrine()->getRepository(Commande::class)->findBy(array("idCommande"=>$idCommande));
        $em=$this->getDoctrine()->getManager();
        foreach($form as $product) {
            $em->remove($product);
        }

        $em->flush();

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('idCommande' =>  $commande->getIdcommande())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    private function createProduitCommandeForm(Commande $commande)
    {
        return $this->getDoctrine()->getManager()->getRepository('CommandeBundle:ProduitCommande')
        ->findBy(array('idCommande' => $commande->getIdcommande()));
    }


    private function createProduitForm(ProduitCommande $produit)
    {
        return $this->getDoctrine()->getManager()->getRepository('EntrepotBundle:Produit')
            ->findOneBy(array('idProduit' => $produit->getIdProduit()));
    }
    private function createEntrepotForm(Produit $produit)
    {
        return $this->getDoctrine()->getManager()->getRepository('EntrepotBundle:Entrepot')
            ->findOneBy(array('fkEntrepot' => $produit->getFkEntrepot()));
    }

    public function chiffrementAction(Commande $commande)
    {
        $a=$commande->getIdCommande();
        $x ="7291048536";
        $y="ABCDEFHIKL";
        $z=$y[$a%10].$x[$a%10];
        while (($a/10)>1)
        { $a=$a/10;
            $z=$y[$a%10]. $x[$a%10].$z;
        }

        return $this->json($z);


    }



}

