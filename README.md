# README

## SYSTEM REQUIREMENT

* DB
  - MySQL 5.6
* Apache 
    - 2.4
* PHP
  - 8.1
* Laravel
  - 8.8
* Composer
  - 1.4.1

* Nodejs
  - 14
  
* Npm
    - 6.14

* config
```bash
 npm install
 composer install or composer install --ignore-platform-reqs
 php artisan config:cache
 php artisan config:clear
 php artisan cache:clear
```

* run deploy
```bash
cp .env.example .env
php artisan key:generate
```
* config your database in .env
find and replace database config
```bash
vi .env
```
* run database
```bash
php artisan migrate
php artisan db:seed
```

* run project
```bash
    For FE (laravel): php artisan serve
    For Admin (reactjs): npm run watch
```

* admin
```bash
    For Admin role: /management/login
        - admin@gmail.com/123456
        - manager@gmail.com/123456
    For Teacher role: /management-teacher/login
```

