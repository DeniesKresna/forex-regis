#!/bin/sh
set -e

if [ ! -f .env ]; then
  cp .env.example .env
fi

if [ -z "$(grep '^APP_KEY=' .env | cut -d= -f2-)" ]; then
  php artisan key:generate --force
fi

if [ ! -f vendor/autoload.php ] && [ -d /opt/vendor ]; then
  mkdir -p vendor
  cp -a /opt/vendor/. vendor/
fi

php artisan config:clear >/dev/null 2>&1 || true

echo "Waiting for MySQL..."
until php -r 'try { new PDO("mysql:host=".getenv("DB_HOST").";port=".getenv("DB_PORT"), getenv("DB_USERNAME"), getenv("DB_PASSWORD")); exit(0); } catch (Throwable $e) { exit(1); }'; do
  sleep 2
done

echo "Running migrations..."
php artisan migrate --force --seed

echo "Starting Laravel..."
exec php artisan serve --host=0.0.0.0 --port=8000
