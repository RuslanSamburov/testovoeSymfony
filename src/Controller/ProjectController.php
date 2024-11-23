<?php

namespace App\Controller;

use App\Exceptions\ProjectValidationException;
use App\Services\ProjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectController extends AbstractController
{
    public function __construct(
        private ProjectService $_projectService,
    ) {}

    #[Route('/projects', 'list_project', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $this->_projectService->getAll($em),
        ]);
    }

    #[Route('/project', name: 'create_project', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        try 
        {
            $this->_projectService->create($request->request->all(), $em, $validator);
        } catch (ProjectValidationException $e) {}

        return $this->redirectToRoute('list_project');
    }

    #[Route('/project/close/{id}', 'close_project', methods: ['POST'])]
    public function close(int $id, EntityManagerInterface $em): Response
    {
        $this->_projectService->close($id, $em);

        return $this->redirectToRoute('list_project');
    }
}
