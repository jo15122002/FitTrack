<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Form\GoalType;
use App\Repository\GoalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class GoalController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/goal', name: 'app_goal')]
    public function index(): Response
    {
        return $this->render('goal/index.html.twig', [
            'controller_name' => 'GoalController',
        ]);
    }

    #[Route('/goal/add', name: 'app_goal_add')]
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $goal = new Goal();
        $form = $this->createForm(GoalType::class, $goal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $goal = $form->getData();
            $goal->setAuthor($this->getUser());

            $entityManager->persist($goal);
            $entityManager->flush();


            // Redirigez l'utilisateur vers une page appropriée
            return $this->redirectToRoute('app_goal_list');
        }

        return $this->render('goal/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/goal/list', name: 'app_goal_list')]
    public function list(EntityManagerInterface $entityManager)
    {
        $goals = $entityManager->getRepository(Goal::class)->findBy(['author' => $this->getUser()]);

        return $this->render('goal/list.html.twig', [
            'goals' => $goals,
        ]);
    }

    #[Route('/goal/{id}', name: 'app_goal_show')]
    public function show(int $id, GoalRepository $goalRepository)
    {
        $goal = $goalRepository->find($id);

        if (!$goal) {
            throw $this->createNotFoundException('Objectif non trouvé.');
        }

        return $this->render('goal/show.html.twig', [
            'goal' => $goal,
        ]);
    }

    #[Route('/goal/edit/{id}', name: 'app_goal_edit')]
    public function edit(int $id, GoalRepository $goalRepository, Request $request, EntityManagerInterface $entityManager, Security $security)
    {
        $goal = $goalRepository->find($id);

        if (!$goal) {
            throw $this->createNotFoundException('Objectif non trouvé.');
        }

        $form = $this->createForm(GoalType::class,$goal, [
            'user' => $security->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $goal = $form->getData();
            $goal->setAuthor($this->getUser());

            $entityManager->persist($goal);
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page appropriée
            return $this->redirectToRoute('app_goal_list');
        }

        return $this->render('goal/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/goal/delete/{id}', name: 'app_goal_delete')]
    public function delete(int $id, GoalRepository $goalRepository, EntityManagerInterface $entityManager)
    {
        $goal = $goalRepository->find($id);

        if (!$goal) {
            throw $this->createNotFoundException('Objectif non trouvé.');
        }

        $entityManager->remove($goal);
        $entityManager->flush();

        // Redirigez l'utilisateur vers une page appropriée
        return $this->redirectToRoute('app_goal_list');
    }
}
