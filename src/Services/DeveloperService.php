<?php

namespace App\Services;

use App\Entity\{Developer, Project};
use App\Exceptions\DeveloperValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class DeveloperService
{
    /**
     * @return Developer[] || array<Developer>
     */
    public function getAll(EntityManagerInterface $em): array
    {
        $developers = $em->getRepository(Developer::class)->findAll();
        return $developers;
    }

    public function create(array $data, EntityManagerInterface $em, ValidatorInterface $validator): void
    {
        $developer = new Developer($data);
        
        $project = $em->getRepository(Project::class)->findOneBy([
            'id' => $data['project_id'] ?? null,
            'is_active' => true
        ]);

        if (!$project) 
        {
            return;
        }

        $developer->setProject($project);

        $errors = $validator->validate($developer);

        if (count($errors) > 0) {
            throw new DeveloperValidationException($errors);
        }

        $em->persist($developer);
        $em->flush();
    }

    public function getDeveloperProfile(int $id, EntityManagerInterface $em): Developer
    {
        return $em->getRepository(Developer::class)->find($id);
    }

    public function yvolitDeveloper(int $id, EntityManagerInterface $em): void 
    {
        $developer = $this->getDeveloperProfile($id, $em);
        
        $em->remove($developer);
        $em->flush();
    }

    public function updateProfileDeveloper(array $data, int $id, EntityManagerInterface $em): void
    {
        $developer = $this->getDeveloperProfile($id, $em);

        if (isset($data['position'])) 
        {
            $developer->setPosition($data['position']);
        }

        if (isset($data['project_id'])) 
        {
            $project = $em->getRepository(Project::class)->find($data['project_id']);
            $developer->setProject($project);
        }
        
        $em->flush();
    }
}
