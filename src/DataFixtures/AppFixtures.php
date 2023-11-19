<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Goal;
use App\Entity\User;
use App\Entity\WorkoutPlan;
use App\Enum\GoalStatus;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $output = new ConsoleOutput();
        // Créer plusieurs utilisateurs
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user' . $i)
                ->setEmail('user' . $i . '@example.com')
                ->setPassword('password' . $i); // Utilisez un encodeur de mot de passe en production

            $manager->persist($user);
            $manager->flush();

            $activities = [];
            // Créer quelques activités pour chaque utilisateur
            for ($j = 0; $j < 3; $j++) {
                $activity = new Activity();
                $activity->setType('Type ' . $j)
                    ->setDistance(5 * $j)
                    ->setDuration(30 * $j)
                    ->setName('Activité ' . $j)
                    ->setDate(new DateTime())
                    ->setAuthor($user);

                $manager->persist($activity);
                $activities[] = $activity;
            }
            $manager->flush();

            // Créer des objectifs pour chaque utilisateur
            for ($k = 0; $k < 2; $k++) {
                $goal = new Goal();
                $goal->setDescription('Objectif ' . $k)
                    ->setDeadline(new DateTime('+1 month'))
                    ->setAuthor($user)
                    ->setStatus('En cours'); // Assurez-vous que cette valeur est valide

                $manager->persist($goal);
            }
            $manager->flush();

            // Créer un plan d'entraînement pour chaque utilisateur
            $workoutPlan = new WorkoutPlan();
            $workoutPlan->setDescription('Plan ' . $i);
            foreach ($activities as $activity) {
                $workoutPlan->addActivity($activity);
                $manager->persist($activity);
            }

            $manager->persist($workoutPlan);
            $manager->flush();
        }

        // Enregistrer toutes les entités
        $manager->flush();
    }
}
