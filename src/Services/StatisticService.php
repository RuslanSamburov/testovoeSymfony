<?php

namespace App\Services;

use App\Entity\Developer;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class StatisticService
{
    public function TotalProjects(EntityManagerInterface $em): int
    {
        return $em->getRepository(Project::class)->count();
    }

    public function TotalDevelopers(EntityManagerInterface $em): int
    {
        return $em->getRepository(Developer::class)->count();
    }

    public function DeveloperCountPerProject(EntityManagerInterface $em): mixed
    {
        return $em->createQueryBuilder()
            ->select('p.title AS projectTitle, COUNT(d.id) AS developerCount')
            ->from(Project::class, 'p')
            ->leftJoin('p.developers', 'd')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    public function ProjectWithMostDevelopers(EntityManagerInterface $em): mixed
    {
        return $em->createQueryBuilder()
            ->select('p.title AS projectTitle, COUNT(d.id) AS developerCount')
            ->from(Project::class, 'p')
            ->leftJoin('p.developers', 'd')
            ->groupBy('p.id')
            ->orderBy('developerCount', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
