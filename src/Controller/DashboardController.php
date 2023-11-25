<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ActivityRepository $activityRepository)
    {
        // Récupérer les données utilisateur
        $user = $this->getUser(); // Assurez-vous que l'utilisateur est connecté

        $labels = ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'];
        $data = [5, 10, 3, 8]; // Exemple de nombres d'activités par semaine

        // Calculer les statistiques
        $totalActivities = $activityRepository->countActivitiesForUser($user);
        $totalDistance = $activityRepository->sumDistanceForUser($user);

        // Renvoyer les données à la vue
        return $this->render('dashboard/index.html.twig', [
            'totalActivities' => $totalActivities,
            'totalDistance' => $totalDistance,
            'activityLabels' => $labels,
            'activityData' => $data,
        ]);
    }
}
