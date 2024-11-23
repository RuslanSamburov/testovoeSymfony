<?php

namespace App\Services;

use App\Entity\Project;
use App\Exceptions\ProjectValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProjectService 
{
    /**
     * @return Project[] || array<Project>
     */
    public function getAll(EntityManagerInterface $em): array
    {
        $projects = $em->getRepository(Project::class)->findBy([], ['is_active' => 'DESC']);
        return $projects;
    }

    public function getActiveProjects(EntityManagerInterface $em) 
    {
        $projects = $em->getRepository(Project::class)->findBy(['is_active' => true]);
        return $projects;
    }

    public function create(array $data, EntityManagerInterface $em, ValidatorInterface $validator): void
    {
        $project = new Project($data);

        $errors = $validator->validate($project);

        if (count($errors) > 0) {
            throw new ProjectValidationException($errors);
        }

        $em->persist($project);
        $em->flush();
    }

    public function close(int $id, EntityManagerInterface $em): void
    {
        $project = $em->getRepository(Project::class)->find($id);

        $project->setActive(false);

        $em->flush();
    }
}
