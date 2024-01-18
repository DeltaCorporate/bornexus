# Lancement du projet en local
## Prérequis
Symfony cli : à installer ici: https://symfony.com/download
docker
npm
## Installation

1. Cloner le projet
2. Lancer les containers docker
```bash
docker-compose up -d
```
3. Copier le fichier .env.example en .env
```bash
cp .env.example .env
```
4. Installer les dépendances php
```bash
composer install
```
5. Installer les dépendances js
```bash
npm install
```
6. Créer la base de données if not exist
```bash
php bin/console doctrine:database:create --if-not-exists
```
7. Lancer les migrations
```bash
php bin/console doctrine:migrations:migrate
```
8. Lancer les fixtures
```bash
php bin/console doctrine:fixtures:load
```
9. Lancer le watcher
```bash
npm run dev
```
10. Lancer le serveur de dev
```bash
symfony server:start
```

## Accès
- Front : http://localhost:8000

# Commencez à travailler