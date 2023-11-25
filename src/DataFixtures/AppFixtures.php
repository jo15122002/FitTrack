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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $output = new ConsoleOutput();

        // Créer plusieurs utilisateurs
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user' . $i)
                ->setEmail('user' . $i . '@example.com')
                ->setPassword($this->passwordHasher->hashPassword($user, 'password'));

            $manager->persist($user);

            // Créer quelques activités pour chaque utilisateur
            for ($j = 0; $j < 3; $j++) {
                $activity = new Activity();
                $activity->setType('Type ' . $j)
                    ->setDistance(5 * $j)
                    ->setDuration(30 * $j)
                    ->setDate(new DateTime())
                    ->setAuthor($user)
                    ->setName('Activité ' . $j);

                $manager->persist($activity);

                // Créer un plan d'entraînement pour chaque activité
                $workoutPlan = new WorkoutPlan();
                $workoutPlan->setDescription('Plan ' . $j)
                    ->addActivity($activity)
                    ->setAuthor($user);

                $manager->persist($workoutPlan);
            }

            // Créer des objectifs pour chaque utilisateur
            for ($k = 0; $k < 2; $k++) {
                $goal = new Goal();
                $goal->setDescription('Objectif ' . $k)
                    ->setDeadline(new DateTime('+1 month'))
                    ->setAuthor($user)
                    ->setStatus('En cours');

                $manager->persist($goal);
            }

            $output->writeln('Utilisateur ' . $user->getUsername() . ' et ses données associées créés.');
        }

        $manager->flush();
    }
}
