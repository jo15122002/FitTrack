<?php

namespace App\Controller;

use App\Entity\WorkoutPlan;
use App\Form\WorkoutPlanType;
use App\Repository\WorkoutPlanRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class WorkoutPlanController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/workoutplan', name: 'app_workout_plan')]
    public function index(): Response
    {
        return $this->render('workout_plan/index.html.twig', [
            'controller_name' => 'WorkoutPlanController',
        ]);
    }

    //add
    #[Route('/workoutplan/add', name: 'app_workout_plan_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workoutPlan = new WorkoutPlan();
        $form = $this->createForm(WorkoutPlanType::class, $workoutPlan);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->security->getUser();
            if (!$user) {
                // Gérer le cas où aucun utilisateur n'est connecté
                throw $this->createAccessDeniedException('Vous devez être connecté pour créer un plan.');
            }

            // Associer l'utilisateur connecté à l'entité WorkoutPlan
            // Supposons que votre entité WorkoutPlan a une méthode setUser() pour cela
            $workoutPlan->setAuthor($user);

            $entityManager->persist($workoutPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_workout_plan_list');
        }

        return $this->render('workout_plan/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/workoutplan/list', name: 'app_workout_plan_list')]
    public function list(WorkoutPlanRepository $workoutPlanRepository): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            // Gérer le cas où aucun utilisateur n'est connecté
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer uniquement les WorkoutPlan liés à l'utilisateur connecté
        $workoutPlans = $workoutPlanRepository->findByUser($user);

        return $this->render('workout_plan/list.html.twig', [
            'controller_name' => 'WorkoutPlanController',
            'workoutPlans' => $workoutPlans,
        ]);
    }

    #[Route('/workoutplan/{id}', name: 'app_workout_plan_show')]
    public function show(WorkoutPlanRepository $workoutPlanRepository, int $id): Response
    {
        $workoutPlan = $workoutPlanRepository->find($id);

        return $this->render('workout_plan/show.html.twig', [
            'controller_name' => 'WorkoutPlanController',
            'workoutPlan' => $workoutPlan,
        ]);
    }

    #[Route('/workoutplan/edit/{id}', name: 'app_workout_plan_edit')]
    public function edit(WorkoutPlanRepository $workoutPlanRepository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $workoutPlan = $workoutPlanRepository->find($id);
        $form = $this->createForm(WorkoutPlanType::class, $workoutPlan);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workoutPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_workout_plan_list');
        }

        return $this->render('workout_plan/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
