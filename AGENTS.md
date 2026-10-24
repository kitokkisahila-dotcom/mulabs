# Repository Guidelines

## Project Structure & Module Organization

This is a Laravel 12 application. Application code is in `app/`: HTTP controllers in `app/Http/Controllers`, Eloquent models in `app/Models`, and service providers in `app/Providers`. Routes are defined in `routes/web.php` (web) and `routes/console.php` (CLI). Blade templates live in `resources/views`; frontend CSS and JavaScript are in `resources/css` and `resources/js`. Database migrations, factories, and seeders are under `database/`. Public files and images belong in `public/`. Tests are split into `tests/Feature` and `tests/Unit`.

## Build, Test, and Development Commands

- `composer setup` installs PHP and Node dependencies, creates `.env` when needed, generates an app key, migrates the database, and builds assets.
- `composer dev` starts the Laravel server, queue listener, Pail logs, and Vite development server together.
- `npm run dev` runs Vite for frontend development; `npm run build` produces production assets.
- `composer test` clears cached configuration and runs the Laravel test suite. Use `php artisan test --filter=ClassName` for a focused test.
- `php artisan migrate` applies local database migrations.

## Coding Style & Naming Conventions

Follow `.editorconfig`: UTF-8, LF endings, four spaces, final newlines, and no trailing whitespace (Markdown is exempt). Use Laravel and PSR-4 conventions: `StudlyCase` classes, `camelCase` methods/variables, and descriptive singular model names such as `Laboratory` or `Report`. Keep controllers focused on request handling; place database schema changes in timestamped migrations. Run `./vendor/bin/pint` before submitting PHP changes.

## Testing Guidelines

Write request, authentication, and database-flow tests in `tests/Feature`; reserve `tests/Unit` for isolated logic. Name tests by behavior, e.g. `test_admin_can_view_dashboard`. Use factories and Laravel test helpers rather than relying on existing local data. Run `composer test` before opening a pull request; add regression coverage for fixes and coverage for new behavior.

## Commit & Pull Request Guidelines

Git history is not available in this checkout, so use concise, imperative commit subjects, such as `Add laboratory availability validation`. Keep each commit scoped to one change. Pull requests should explain the user-facing or technical impact, list validation performed, link related issues where available, and include screenshots for Blade/UI changes. Call out migration, configuration, or environment-variable changes explicitly.

## Security & Configuration

Never commit `.env`, secrets, or production credentials. Add new configuration keys to `.env.example` with safe placeholders and document any required setup in the pull request.
