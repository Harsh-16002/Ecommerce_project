#!/usr/bin/env bash
set -euo pipefail

export PORT="${PORT:-10000}"

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is required. Set it in Render before deploying."
    exit 1
fi

if [ -z "${DB_URL:-}" ] && [ "${DB_CONNECTION:-sqlite}" = "pgsql" ]; then
    echo "DB_URL is required when DB_CONNECTION=pgsql."
    exit 1
fi

envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

php artisan storage:link || true
php artisan migrate --force
php artisan db:seed --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
