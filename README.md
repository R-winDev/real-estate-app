# Real Estate App

A real estate listing platform built with Laravel.

> Features are currently being defined and developed.

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.3)
- **Database:** MySQL 8.0
- **Web Server:** Nginx
- **Containerization:** Docker Compose

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Getting Started

```bash
# 1. Clone the repository
git clone <repo-url> real-estate-app
cd real-estate-app

# 2. Copy environment file
cp .env.example .env

# 3. Build and start containers
docker compose up -d --build

# 4. Install PHP dependencies
docker compose exec php composer install

# 5. Generate application key
docker compose exec php php artisan key:generate

# 6. Run database migrations
docker compose exec php php artisan migrate

# 7. (Optional) Seed sample data
docker compose exec php php artisan db:seed
```

The application will be available at [http://localhost:8080](http://localhost:8080).

## Development

```bash
# View logs
docker compose logs -f

# Run artisan commands
docker compose exec php php artisan <command>

# Run tests
docker compose exec php php artisan test

# Run composer commands
docker compose exec php composer <command>
```

## Stopping

```bash
docker compose down
```

To also remove the database volume:

```bash
docker compose down -v
```

## Project Structure

```
├── docker/
│   ├── nginx/          # Nginx configuration
│   └── php/            # PHP-FPM Dockerfile
├── app/                # Application code
├── config/             # Configuration files
├── database/           # Migrations and seeds
├── resources/          # Views and front-end assets
├── routes/             # Route definitions
└── docker-compose.yml  # Docker orchestration
```

## License

[MIT](https://opensource.org/licenses/MIT)
