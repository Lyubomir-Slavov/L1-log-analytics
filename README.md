# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Run migrations `docker compose exec php bin/console doctrine:migrations:migrate`
5. Load sample file `docker compose exec php bin/console app:sync-log /app/tests/samples/logs.log`
6. Open `https://localhost/count` in your favorite web browser and [accept the auto-generated TLS certificate]
   (https://stackoverflow.com/a/15076602/1352334)
7. Run tests `docker compose exec -e APP_ENV=test php bin/phpunit`
8. Documentation: https://localhost/api/doc

## If you want to use the MakeFile
1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `make build`
3. Run `make run`
4. Run migrations `make sf c='doctrine:migrations:migrate'`
5. Load sample file `make sf c='app:sync-log /app/tests/samples/logs.log'`
6. Open `https://localhost/count` in your favorite web browser and [accept the auto-generated TLS certificate]
   (https://stackoverflow.com/a/15076602/1352334)
7. Run tests `make test`
8. Documentation: https://localhost/api/doc
