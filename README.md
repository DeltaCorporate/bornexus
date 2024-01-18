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
3. Installer les dépendances php
```bash
composer install
```
4. Installer les dépendances js
```bash
npm install
```
5. Créer la base de données if not exist
```bash
php bin/console doctrine:database:create --if-not-exists
```
6. Lancer les migrations
```bash
php bin/console doctrine:migrations:migrate
```
7. Lancer les fixtures
```bash
php bin/console doctrine:fixtures:load
```
8. Lancer le watcher
```bash
npm run dev
```
9. Lancer le serveur de dev
```bash
symfony server:start
```

## Accès
- Front : http://localhost:8000

# Commencez à travailler