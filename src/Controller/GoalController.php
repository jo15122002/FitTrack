<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Form\GoalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoalController extends AbstractController
{
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
            return $this->redirectToRoute('goal_list');
        }

        return $this->render('goal/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
