<?php

namespace App\Controller;

use App\Services\StatisticService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatisticController extends AbstractController
{
    public function __construct(
        private StatisticService $_statisticService,
    ) {}

    #[Route('/statistic', name: 'app_statistic', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->json([
            'totalProjects' => $this->_statisticService->TotalProjects($em),
            'totalDevelopers' => $this->_statisticService->TotalDevelopers($em),
            'developerCountPerProject' => $this->_statisticService->DeveloperCountPerProject($em),
        ]);
    }
}
