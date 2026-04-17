<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Deploying To Render

This repo now includes a Docker-based Render setup:

- `render.yaml`
- `Dockerfile`
- `scripts/start.sh`
- `conf/nginx/default.conf.template`
- `conf/supervisor/supervisord.conf`

### What To Create In Render

1. Push this repository to GitHub, GitLab, or Bitbucket.
2. In Render, create a PostgreSQL database.
3. In Render, create a new Blueprint or Web Service from this repository.
4. If you use the included `render.yaml`, set these secret environment variables in the Render dashboard before the first successful deploy:

- `APP_URL`
- `APP_KEY`
- `DB_URL`
- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`
- `ADMIN_PHONE`
- `ADMIN_ADDRESS`
- `PAYPAL_MODE`
- `PAYPAL_SANDBOX_CLIENT_ID`
- `PAYPAL_SANDBOX_CLIENT_SECRET`
- `PAYPAL_LIVE_CLIENT_ID`
- `PAYPAL_LIVE_CLIENT_SECRET`
- `PAYPAL_LIVE_APP_ID`
- `PAYPAL_NOTIFY_URL`
- Any mail or AWS variables your production flow depends on

### Required Values

- `APP_KEY`: run `php artisan key:generate --show` locally and paste the output into Render
- `DB_URL`: use your Render PostgreSQL internal connection string
- `APP_URL`: set this to your Render service URL, such as `https://your-app-name.onrender.com`
- `ADMIN_EMAIL` and `ADMIN_PASSWORD`: used by `AdminSeeder` to create or promote your first admin account

### Seeded Data

- `AdminSeeder` creates or updates the admin account with `usertype = admin`
- The admin account is marked verified by setting `email_verified_at`
- `CategorySeeder` loads the storefront categories
- `ProductSeeder` loads the storefront products
- Startup runs `php artisan db:seed --force`, and all included seeders use idempotent writes so repeat deploys stay safe

### Notes

- The app starts with Nginx + PHP-FPM inside Docker.
- On startup, the container runs `php artisan migrate --force`.
- Because Render's filesystem is ephemeral, production should use PostgreSQL instead of SQLite.
- Uploaded files stored only on the local filesystem will not persist across redeploys. If you need persistent user uploads later, move them to S3-compatible storage or attach a Render disk and update the storage strategy.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
