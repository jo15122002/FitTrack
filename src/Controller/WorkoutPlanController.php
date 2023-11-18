<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutPlanController extends AbstractController
{
    #[Route('/workout/plan', name: 'app_workout_plan')]
    public function index(): Response
    {
        return $this->render('workout_plan/index.html.twig', [
            'controller_name' => 'WorkoutPlanController',
        ]);
    }
}
