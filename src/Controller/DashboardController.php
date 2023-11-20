<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index()
    {
        // Ici, vous pouvez passer des données ou des statistiques à la vue si nécessaire

        return $this->render('dashboard/index.html.twig');
    }
}
