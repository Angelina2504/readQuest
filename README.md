# ReadQuest

Application de quête littéraire pour explorer de nouvelles lectures ou se motiver à lire.

## Stack technique

| Couche | Technologie |
|--------|-------------|
| Frontend | Vue.js 3, Pinia, Vue Router |
| Backend | Symfony 7, PHP 8.3 |
| Base de données | MySQL 8.4, MongoDB 8.0 |
| Serveur | Nginx |
| Conteneurisation | Docker, Docker Compose |

## Prérequis

- Docker & Docker Compose
- Git

## Installation

### 1. Cloner le dépôt

```bash
git clone <url-du-repo>
cd readQuest
```

### 2. Configurer les variables d'environnement

```bash
cp .env.example .env
cp backend/.env.example backend/.env
cp backend/.env.test.example backend/.env.test
```

Remplir les valeurs dans chaque `.env`.

### 3. Générer les clés JWT

```bash
docker exec readquest-backend php bin/console lexik:jwt:generate-keypair
```

### 4. Lancer l'application

> **Note :** Docker Desktop doit être lancé avant d'exécuter cette commande.

```bash
docker compose up -d
```

### 5. Initialiser la base de données (premier lancement uniquement)

```bash
docker exec readquest-backend php bin/console doctrine:migrations:migrate
```

L'application est disponible sur :
- Frontend : http://localhost:5173
- Backend API : http://localhost:8080/api

## Tests

### Backend (PHPUnit)

```bash
docker exec readquest-backend php bin/phpunit
```

### Frontend (Vitest)

```bash
docker exec readquest-node npm run test:unit
```
