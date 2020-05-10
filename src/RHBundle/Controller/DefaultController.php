<?php

namespace RHBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WBW\Bundle\HighchartsBundle\API\Chart\HighchartsChart;

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
        $data = [["name" => "Female", "y" => 25 ], ["name" => "Male", "y" => 25], ["name" => "Unknown", "y" => 50]];

        // Initialize the series.
        $series = [["colorByPoint" => true, "data" => $data, "name" => "Gender distribution"]];

        // Initialize the chart.
        $chart = new HighchartsChart;
        $chart->newChart()->setType("pie");
        $chart->newPlotOptions()->newPie()
            ->setAllowPointSelect(true)
            ->setCursor("pointer")
            ->setShowInLegend(true)
            ->newDataLabels()->setEnabled(true);
        $chart->setSeries($series);
        $chart->newTitle()->setText("Gender distribution");
        $chart->newTooltip()->setPointFormat("{series.name}: <b>{point.percentage:.1f}%</b>");
        return $this->render('@RH/admin/admin1.html.twig', array(
            'nbemp' => $nbemp,
            'nbsig' => $nbsig,
            'nbsigemp' => $nbsigemp,
            'nbdep' => $nbdep,
            'empmois' => $empmois,
            'chart' => $chart,
        ));

    }



}
