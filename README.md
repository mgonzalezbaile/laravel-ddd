# LARAVEL SKELETON - Domain Driven Design

## Async Listeners
In order to consume both events and commands asynchronously a worker must be executed:

`env UID=(id -u) GID=(id -g) docker-compose exec laravel php artisan queue:work --queue=laravel-ddd --tries=5 --delay=1` 

- `--queue`: The name of the laravel application (see `APP_NAME` in `.env` file).
- `--tries`: Maximum number of failed attempts to consume a message.
- `--delay`: Time in seconds to wait between attempts.

After the maximum number of attempts is reached the message is stored in the `failed_jobs` database table.
