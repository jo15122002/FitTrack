# Auto-Evaluation
Je me mettrais 4/5 car je pense me débrouiller assez bien en Symfony, mais je ne pense pas être encore au niveau d'un développeur confirmé. J'ai encore beaucoup de choses à apprendre mais je pense que je suis capable de développer des applications web simples, mais je ne suis pas encore à l'aise avec les applications plus complexes. Je suis capable de m'améliorer et de progresser.

# FitTrack

FitTrack est une application web dédiée au suivi de fitness, permettant aux utilisateurs de suivre leurs activités physiques, de définir des objectifs de fitness et de créer des plans d'entraînement personnalisés.

## Fonctionnalités

- **Suivi des Activités**: Enregistrez divers types d'activités physiques comme la course à pied, le cyclisme ou la natation.
- **Gestion des Objectifs**: Définissez et suivez vos objectifs de fitness personnels.
- **Plans d'Entraînement**: Créez et gérez des plans d'entraînement adaptés à vos besoins.
- **Dashboard Utilisateur**: Visualisez vos progrès grâce à un tableau de bord intuitif.
- **Panel Administrateur**: Gérez les utilisateurs et les données depuis une interface d'administration.

## Technologies Utilisées

- Symfony 5
- Bootstrap pour le front-end
- Doctrine ORM pour la gestion de la base de données
- Autres technologies/bibliothèques utilisées

## Installation

Pour installer et exécuter FitTrack localement, suivez ces étapes :

1. Clonez le dépôt :

    ```bash
    git clone https://github.com/jo15122002/FitTrack.git
    ```

2. Installez les dépendances :

    ```bash
    composer install
    ```

3. Configurez votre fichier `.env` avec vos paramètres de base de données et autres configurations nécessaires.

4. Lancez les migrations de la base de données :

    ```bash
    php bin/console doctrine:migrations:migrate
    ```

5. (Optionnel) Chargez les données fictives :

    ```bash
    php bin/console doctrine:fixtures:load
    ```

6. Démarrez le serveur Symfony :

    ```bash
    symfony server:start
    ```

Votre application devrait maintenant être accessible à l'adresse `http://localhost:8000`.