Follow steps below:
- composer install
- php artisan sail:install
- ./vendor/bin/sail up -d
- ./vendor/bin/sail artisan key:generate
- ./vendor/bin/sail artisan migrate
- ./vendor/bin/sail artisan db:seed
- Choose a user's email and login in postman within **localhost/graphql/login** url(all passwords are **password**)
- Take the token and call task CRUD apis with that
- For Running tests: **./vendor/bin/sail artisan test tests/Feature**
