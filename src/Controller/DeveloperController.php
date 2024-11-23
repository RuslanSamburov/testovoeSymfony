<?php

namespace App\Controller;

use App\Exceptions\DeveloperValidationException;
use App\Services\{DeveloperService, ProjectService};
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeveloperController extends AbstractController
{

    public function __construct(
        private DeveloperService $_developerService,
        private ProjectService $_projectService,
    ) {}

    #[Route('/developers', name: 'list_developer', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('developer/index.html.twig', [
            'developers' => $this->_developerService->getAll($em),
            'projects' => $this->_projectService->getActiveProjects($em),
        ]);
    }

    #[Route('/developer', name: 'create_developer', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        try 
        {
            $this->_developerService->create($request->request->all(), $em, $validator);
        } catch (DeveloperValidationException $e) {}

        return $this->redirectToRoute('list_developer');
    }

    #[Route('/developer/{id}', name: 'profile_developer', methods: ['GET'])]
    public function profile(int $id, EntityManagerInterface $em): Response
    {
        return $this->render('developer/profile.html.twig', [
            'developer' => $this->_developerService->getDeveloperProfile($id, $em),
            'projects' => $this->_projectService->getActiveProjects($em),
        ]);
    }

    #[Route('/developer/{id}/yvolen', name: 'yvolen_developer', methods: ['POST'])]
    public function yvolen(int $id, EntityManagerInterface $em): Response
    {
        try 
        {
            $this->_developerService->yvolitDeveloper($id, $em);
        } catch (Exception $e) {}

        return $this->redirectToRoute('list_developer');
    }

    #[Route('/developer/{id}/update', name: 'updateProfile_developer', methods: ['PUT', 'POST'])] // Почему-то не работает PUT
    public function updateProfile(int $id, Request $request, EntityManagerInterface $em): Response
    {
        try 
        {
            $this->_developerService->updateProfileDeveloper($request->request->all(), $id, $em);
        } catch (Exception $e) {}
        return $this->redirectToRoute('updateProfile_developer', [ 'id' => $id ]);
    }
}
