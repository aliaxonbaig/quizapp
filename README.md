
### About QuizApp

A fully functional quiz application developed on TALL stack and filamentphp3.


## Setup

git clone <repo>

cp .env.example .env

sail up -d
sail npm install
sail npm run build
sail npm run dev #should be kept open if using local dev env

sail artisan migrate:fresh

sail artisan make:filament-user

sail artisan db:seed

sail artisan shield:super-admin

sail artisan db:seed --class ShieldSeeder

#Create a test user from admin and assign user role
#Login as test user and i) Subscribe to the certification under subscription menu and then the subscribed quiz certificaitons will appear in the quiz drop down for selection.



## Screenshots
Admin Dashboard

![Screenshot from 2024-02-24 19-02-12](https://github.com/aliaxonbaig/quizapp/assets/52659978/476ccdcb-488d-4356-ad3b-b4adb3e80252)


User Dashboard:
![Screenshot from 2024-02-24 19-07-25](https://github.com/aliaxonbaig/quizapp/assets/52659978/b30abd3d-fe8f-4062-929f-77f3b3cefcb5)


Quiz In-Progress:
![Screenshot from 2024-02-24 19-05-31](https://github.com/aliaxonbaig/quizapp/assets/52659978/c8f67330-e28b-478e-9a23-b341e1425210)


Quiz Result Review:
![Screenshot from 2024-02-24 19-07-01](https://github.com/aliaxonbaig/quizapp/assets/52659978/489d6bc0-39db-4245-8480-1bcc7dd52929)


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
