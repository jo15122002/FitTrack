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

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création d'un utilisateur
        $user = new User();
        $user->setUsername('userdemo')
            ->setEmail('user@example.com')
            ->setPassword('password'); // En production, utilisez une méthode d'encodage de mot de passe

        $manager->persist($user);

        // Création d'une activité
        $activity = new Activity();
        $activity->setType('Course à pied')
            ->setDistance(5.0)
            ->setDuration(30)
            ->setDate(new DateTime())
            ->setAuthor($user);

        $manager->persist($activity);

        // Création d'un objectif
        $goal = new Goal();
        $goal->setDescription('Courir 10 km')
            ->setDeadline(new DateTime('+1 month'))
            ->setAuthor($user)
            ->setStatus(GoalStatus::IN_PROGRESS);

        $manager->persist($goal);

        // Création d'un plan d'entraînement
        $workoutPlan = new WorkoutPlan();
        $workoutPlan->setDescription('Plan Marathon')
            ->addActivity($activity);

        $manager->persist($workoutPlan);

        // Enregistrer toutes les entités
        $manager->flush();
    }
}
