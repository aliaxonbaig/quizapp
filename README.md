
### About QuizApp

A fully functional quiz application developed on TALL stack and filamentphp3.


## Setup

git clone <repo>

cp .env.example .env

sail up -d

sail artisan migrate:fresh

sail artisan make:filament-user

sail artisan db:seed

sail artisan shield:super-admin

sail artisan db:seed --class ShieldSeeder



## Screenshots

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
