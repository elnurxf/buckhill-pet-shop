# Buckhill Pet Shop API

API has been written using Laravel 10 for Buckhill final technical task

## Setup

Clone this project.

```bash
git clone https://github.com/elnurxf/buckhill-pet-shop.git
```

## Installation

Copy .env.example to .env file, set DB credentials and run migrations and seed database

```bash
composer install
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

## Create keys for JWT

```bash
ssh-keygen -b 4096 -m PEM -t rsa -f storage/app/jwt-keys/jwtRS256.key
ssh-keygen -e -m PEM -f storage/app/jwt-keys/jwtRS256.key > storage/app/jwt-keys/jwtRS256.key.pub
````

## Running Tests

To run tests

```bash
composer test
```

## Analyze with Larastan

To run analyzer

```bash
composer analyse
```