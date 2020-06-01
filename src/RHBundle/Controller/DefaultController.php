<?php

namespace RHBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WBW\Bundle\HighchartsBundle\API\Chart\HighchartsChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use RHBundle\Entity\Departement;
use RHBundle\Entity\Employe;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@RH/Default/index.html.twig');
    }

    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $req2 = $em->createQuery('SELECT e FROM RHBundle:Employe e WHERE e.points=100');
        $empmois= $req2->getResult();
        $req = $em->createQuery('SELECT COUNT(c) cnt FROM RHBundle:Departement c');
        $nbdep= $req->getOneOrNullResult();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(c) cnt FROM RHBundle:Employe c');
        $nbemp= $query->getOneOrNullResult();
        $query2= $em->createQuery('SELECT COUNT(c) cnt FROM RHBundle:Employe c WHERE c.signalemp=0');
        $nbsig=$query2->getOneOrNullResult();
        $query3= $em->createQuery('SELECT COUNT(c) cnt FROM RHBundle:Employe c WHERE c.signalemp>=5');
        $nbsigemp=$query3->getOneOrNullResult();
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $deps = $em->getRepository('RHBundle:Departement')->findAll();
        $emps = $em->getRepository('RHBundle:Employe')->findAll();
        $data= array();
        $stat=['departement', 'nbEmploye'];
        array_push($data,$stat);

        foreach ($deps as $dep){
            $stat=array();
            array_push($stat,$dep->getNom(),$dep->getNbsalles());
            $nb=$dep->getNbsalles();
            $stat=[$dep->getNom(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentage des salles occupées par departements');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(700);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        $pieChart2 = new PieChart();
        $data2= array();
        $stat2=['departement', 'nbEmploye'];
        array_push($data2,$stat2);

        foreach ($emps as $emp){
            $stat2=array();
            array_push($stat,$emp->getNom(),$emp->getNbcong());
            $nb=$emp->getNbcong();
            $stat2=[$emp->getNom(),$nb];
            array_push($data2,$stat2);
        }
        $pieChart2->getData()->setArrayToDataTable(
            $data2
        );
        $pieChart2->getOptions()->setTitle('Pourcentage des signals  par employees');
        $pieChart2->getOptions()->setHeight(500);
        $pieChart2->getOptions()->setWidth(700);
        $pieChart2->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart2->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart2->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@RH/admin/admin1.html.twig', array(
            'nbemp' => $nbemp,
            'nbsig' => $nbsig,
            'nbsigemp' => $nbsigemp,
            'nbdep' => $nbdep,
            'empmois' => $empmois,
            'piechart' => $pieChart,
            'piechart2' => $pieChart2,
        ));

    }



    public function countemp($idDep){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(c) cnt FROM RHBundle:Employe c JOIN c.fkDep d where d.idDep=:item')
            ->setParameter('item',$idDep);
        return $query->getResult();
    }


}
