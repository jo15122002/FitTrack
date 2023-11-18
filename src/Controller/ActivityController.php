<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    #[Route('/activity', name: 'app_activity')]
    public function index(): Response
    {
        return $this->render('activity/index.html.twig', [
            'controller_name' => 'ActivityController',
        ]);
    }

    #[Route('/activity/add', name: 'app_activity_add')]
    public function add(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez l'activité en base de données
            // ...

            // Redirigez l'utilisateur vers une page appropriée
            return $this->redirectToRoute('activity_list');
        }

        return $this->render('activity/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/activity/list', name: 'app_activity_list')]
    public function list(ActivityRepository $activityRepository)
    {
        $activities = $activityRepository
            ->findAll();

        return $this->render('activity/list.html.twig', [
            'activities' => $activities,
        ]);
    }
}
