<?php

namespace App\Controller;

use App\Repository\WorkoutPlanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutPlanController extends AbstractController
{
    #[Route('/workoutplan', name: 'app_workout_plan')]
    public function index(): Response
    {
        return $this->render('workout_plan/index.html.twig', [
            'controller_name' => 'WorkoutPlanController',
        ]);
    }

    #[Route('/workoutplan/add', name: 'app_workout_plan_add')]
    public function add(): Response
    {
        return $this->render('workout_plan/add.html.twig', [
            'controller_name' => 'WorkoutPlanController',
        ]);
    }

    #[Route('/workoutplan/list', name: 'app_workout_plan_list')]
    public function list(WorkoutPlanRepository $workoutPlanRepository): Response
    {
        $workoutPlans = $workoutPlanRepository->findAll();


        return $this->render('workout_plan/list.html.twig', [
            'controller_name' => 'WorkoutPlanController',
            'workoutPlans' => $workoutPlans,
        ]);
    }
}
