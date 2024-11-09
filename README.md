# Food delivery app

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x)
 
Clone the repository

    git clone https://github.com/BrainStation23HR/PHP_Forhad

Switch to the repo folder

    cd food-delivery-app

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Docker
    docker compose build
    docker compose up -d
    
## Database seeding

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
# Testing

    php artisan test

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the middleware
- `app/Http/Requests` - Contains all the requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| Accept        	| application/json	|
----------
