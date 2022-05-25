<?php

namespace App\Controller;

use App\Service\StatisticReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic/all", name="app_statistic_all_url", methods="GET")
     * @param StatisticReportService $statisticReportService
     * @return Response
     */
    public function getAll(StatisticReportService $statisticReportService): Response
    {
        return $this->json(['status' => 'OK', 'statistics' => $statisticReportService->getStatistics()]);
    }

}
