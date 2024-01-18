# Lancement du projet en local

## Installation

1. Cloner le projet
2. Copier le fichier .env.example en .env
    ```bash
    cp .env.example .env
    ```
3. Lancer les containers docker
    ```bash
    docker compose up
    ```
4. Installer les dépendances php
    ```bash
    docker compose exec php composer install
    ```
5. Créer la base de données if not exist
    ```bash
    docker compose exec php bin/console doctrine:database:create --if-not-exists
    ```
6. Lancer les migrations
    ```bash
    docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
    ```
7. Lancer les fixtures
    ```bash
    docker compose exec php bin/console doctrine:fixtures:load --no-interaction
    ```
8. Installer les dépendances js
    ```bash
    npm install
    ```
9. Lancer le watcher
    ```bash
    npm run dev
    ```
10. Lancer le terminal du container
    ```bash
    docker compose exec -it php bash
    ```

## Accès
- Front : https://localhost:8000 (accessible en https)

# Commencez à travailler