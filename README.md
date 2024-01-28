# Lancement du projet en local

## Installation

* Cloner le projet
* Copier le fichier .env.example en .env
    ```bash
    cp .env.example .env
    ```
* Lancer les containers docker
    ```bash
    docker compose up
    ```
* Installer les dépendances php
    ```bash
    docker compose exec php composer install
    ```
* Créer la base de données if not exist
    ```bash
    docker compose exec php bin/console doctrine:database:create --if-not-exists
    ```
* Lancer les migrations
    ```bash
    docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
    ```
* Lancer les fixtures
    ```bash
    docker compose exec php bin/console doctrine:fixtures:load --no-interaction
    ```
* Installer les dépendances js
    ```bash
    npm install
    ```
* Lancer le terminal du container
    ```bash
    docker compose exec -it php bash
    ```

## Accès
- Front : https://localhost:8000 (accessible en https)

# Commencez à travailler