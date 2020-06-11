<?php

namespace ForumBundle\Controller;

//use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ForumBundle\Form\PublicationType;
use ForumBundle\Form\CommentaireType;
use FOS\UserBundle\Model\UserInterface;
use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\Publication;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ForumController extends Controller
{
    public function addPublicationAction(Request $request)
    {
        $user=$this->getUser();/*
        if(!is_object($user) || !$user instanceof UserInterface)
        {
            return $this->redirect("http://localhost/pi-dev/web/app_dev.php/login");
        }
*/
        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        if($u->getNbp()==NULL)
        {
            $u->setNbp(1);

        }
        else
        {
            $u->setNbp($u->getNbp()+1);
        }
        $pub=new Publication();
        $date=new \DateTime();
        $pub->setDatep($date);
        $pub->setIdUser($u);
        $form=$this->createForm(PublicationType::class,$pub);
        $form=$form->handleRequest($request);
        if($form->isValid() )
        {
            //$pub->setDescriptionp($form['descriptionp']->getData());
            //$pub->setTypep($form['typep']->getData());
            $pub->setImage($request->get('image'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();
            return $this->redirectToRoute('publication_addPublication');
        }


        $list=$this->getDoctrine()->getRepository(Publication::class)->findAll();
        $list1=$this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        $postotal=0;
        foreach ($list as $row)
        {
            $postotal+=$row->getIdUser()->getNbp();

        }

        $data= array();
        $stat=['User','Postes'];
        $nb=0;
        array_push($data,$stat);
        foreach ($list as $row)
        {
            $stat=array();
//            array_push($stat,$row->getPartenaire()->getNom(),(($row->getMontant())*100)/$montantTotal);
//            $nb=($row->getMontant()*100)/$montantTotal;

            array_push($stat,$row->getCategorie(),$row->getIdUser()->getNbp());

            $nb=$row->getIdUser()->getNbp();

            $stat=[$row->getCategorie()." ",$nb];
            array_push($data,$stat);
        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Publication par Catégorie :');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(1125);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#00008B');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);



        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('@Forum/Publication/addPublication.html.twig',array(
            'form'=>$form->createView(),
            'list1'=>$list1,
            'list'=>$list,
            'pagination' => $pagination,
            'piechart' => $pieChart,
            'u'=>$u
        ));
    }


    public function deleteAction($id)
    {
        $user=$this->getUser();
        /*if(!is_object($user) || !$user instanceof UserInterface)
        {
            return $this->redirect("http://localhost/DebboPiWeb-master/web/app_dev.php/login");
        }*/

        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        $u->setNbp($u->getNbp()-1);
        $pub=$this->getDoctrine()->getRepository(Publication::class)->find($id);
        if($pub->getIdUser() == $u) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($u);
            $em->remove($pub);
            $em->flush();
        }
        return $this->redirectToRoute('publication_addPublication');

    }


    public function deleteCommentAction($id)
    {
        $user=$this->getUser();
       /* if(!is_object($user) || !$user instanceof UserInterface)
        {
            return $this->redirect("http://localhost/DebboPiWeb-master/web/app_dev.php/login");
        }*/

        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        $pub=$this->getDoctrine()->getRepository(Commentaire::class)->find($id);
        if($pub->getIduser() == $u) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($pub);
            $em->flush();
        }
        return $this->redirectToRoute('publication_addPublication');

    }


    public function suppAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user=$this->getUser();
        /*if(!is_object($user) || !$user instanceof UserInterface)
        {
            return $this->redirect("http://localhost/DebboPiWeb-master/web/app_dev.php/login");
        }*/

        $u=$this->getDoctrine()->getRepository(User::class)->find($user);

        $pub=$this->getDoctrine()->getRepository(Publication::class)->find($id);
        $userpost=$pub->getIdUser();
        $userpost->setNbp($userpost->getNbp()-1);
        $comm=$this->getDoctrine()->getRepository(Commentaire::class)->findBy(array('id'=>$id));

        foreach ($comm as $c)
            $em->remove($c);

        $em->persist($userpost);
        $em->remove($pub);
        $em->flush();

        return $this->redirectToRoute('publication_affiche');

    }


    public function suppCommentAction($id)
    {
        $user=$this->getUser();
        /*if(!is_object($user) || !$user instanceof UserInterface)
        {
            return $this->redirect("http://localhost/DebboPiWeb-master/web/app_dev.php/login");
        }*/

        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        $pub=$this->getDoctrine()->getRepository(Commentaire::class)->find($id);
        if($pub->getIduser() == $u) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($pub);
            $em->flush();
        }

        return $this->redirectToRoute('publication_affiche');

    }


    public function afficheAction()
    {
        $user = $this->getUser();
        if ($user->getUsername() != "admin") {
            return $this->redirect("http://localhost/DebboWeb/web/app_dev.php/login");
        }
            $em = $this->getDoctrine()->getRepository(Publication::class)->findAll();

            $postotal = 0;

            foreach ($em as $row) {
                $postotal += $row->getIdUser()->getNbp();

            }

            $data = array();
            $stat = ['User', 'Postes'];
            $nb = 0;
            array_push($data, $stat);
            foreach ($em as $row) {
                $stat = array();
//            array_push($stat,$row->getPartenaire()->getNom(),(($row->getMontant())*100)/$montantTotal);
//            $nb=($row->getMontant()*100)/$montantTotal;

                array_push($stat, $row->getCategorie(), $row->getIdUser()->getNbp());

                $nb = $row->getIdUser()->getNbp();

                $stat = [$row->getCategorie() . " ", $nb];
                array_push($data, $stat);
            }

            $pieChart = new PieChart();
            $pieChart->getData()->setArrayToDataTable($data);
            $pieChart->getOptions()->setTitle('Publication par catégorie :');
            $pieChart->getOptions()->setHeight(500);
            $pieChart->getOptions()->setWidth(1125);
            $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
            $pieChart->getOptions()->getTitleTextStyle()->setColor('#00008B');
            $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
            $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
            $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

            $em1 = $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
            return $this->render('@Forum/Publication/suppPublication.html.twig', array(
                'list' => $em,
                'list1' => $em1,
                'piechart' => $pieChart,

            ));
        }


    public function detailsAction($id,Request $request)
    {
        $user=$this->getUser();
       /*if(!is_object($user) || !$user instanceof UserInterface)
        {
            return $this->redirect("http://localhost/DebboWeb/web/app_dev.php/login");
        }*/
        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        $com=new Commentaire();
        $date=new \DateTime();
        $com->setDatec($date);
        $com->setIduser($user);

        $publication=$this->getDoctrine()->getRepository(Publication::class)->find($id);
        if($request->isMethod('POST') )
        {
            $com->setContenu($request->get('contenu'));
          //  $pu=$this->getDoctrine()->getRepository(Publication::class)->find($request->get('id1'));
            $com->setIdPublication($request->get('id1'));
            $em=$this->getDoctrine()->getManager();

            $em->persist($com);
            $em->flush();
            return $this->redirectToRoute('publication_detailsPublication', array('id' => $publication->getId()));
        }
        $list1=$this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return $this->render('@Forum/Publication/detailsPublication.html.twig',array(
            'pub'=>$publication, 'list1'=>$list1, 'u'=>$u ));
    }

    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $blog = $em->getRepository('ForumBundle:Publication')->findEntitiesByString($requestString);
        if(!$blog)
        {
            $result['blog']['error']="service introuvable :( ";

        }else{
            $result['blog']=$this->getRealEntities($blog);
        }

        return new Response(json_encode($result));

    }
    public function getRealEntities($blog){
        foreach ($blog as $blog){
            $realEntities[$blog->getId()] = [$blog->getTitre(), $blog->getContenu(), $blog->getCategorie()];
        }
        return $realEntities;
    }

    public function ListeAction(Request $request)
    {
        $user=$this->getUser();
        $em=$this->getDoctrine();
        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        $liste=$em->getRepository(Publication::class)->findAll();
        /**
         * @var $pagination \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate($liste,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',2));

        return $this->render('@Forum/Publication/listePublication.html.twig',array(
            "list"=>$result , 'u'=>$u
        ));
    }

}
