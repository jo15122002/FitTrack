<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            $activity->setAuthor($this->getUser());

            $entityManager->persist($activity);
            $entityManager->flush();

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

    #[Route('/activity/{id}', name: 'app_activity_show')]
    public function show(ActivityRepository $activityRepository, int $id)
    {
        $activity = $activityRepository->find($id);

        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    #[Route('/activity/edit/{id}', name: 'app_activity_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, ActivityRepository $activityRepository, int $id)
    {
        $activity = $activityRepository->find($id);
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            $activity->setAuthor($this->getUser());

            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('app_workout_plan_list');
        }

        return $this->render('activity/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/activity/delete/{id}', name: 'app_activity_delete')]
    public function delete(EntityManagerInterface $entityManager, ActivityRepository $activityRepository, int $id)
    {
        $activity = $activityRepository->find($id);
        $entityManager->remove($activity);
        $entityManager->flush();

        return $this->redirectToRoute('activity_list');
    }
}
