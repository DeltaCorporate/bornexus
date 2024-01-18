# Lancement du projet en local

## Installation

1. Cloner le projet
2. Copier le fichier .env.example en .env
```bash
cp .env.example .env
```
3. Lancer les containers docker
```bash
docker compose up -d
```
4. Créer la base de données if not exist
```bash
docker compose exec php bin/console doctrine:database:create --if-not-exists
```
5. Lancer les migrations
```bash
docker compose exec php bin/console doctrine:migrations:migrate
```
6. Lancer les fixtures
```bash
docker compose exec php bin/console doctrine:fixtures:load
```
7. Installer les dépendances js
```bash
npm install
```
8. Lancer le watcher
```bash
npm run dev
```

## Accès
- Front : https://localhost:8000 (accessible en https)

# Commencez à travailler