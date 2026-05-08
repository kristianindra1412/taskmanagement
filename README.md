# taskmanagement

1. Install Dependencies with composer
composer install --no-dev

2. Prepare the database
If the database not exist yet, Can use this SQL to create new database:

CREATE DATABASE `taskmanagement` /*!40100 COLLATE 'utf8mb3_general_ci' */

3. Setup the database connection in .env


4. Run the migration and seeder to populate the database (optional)
php artisan migrate:fresh

#with seed (optional)
php artisan migrate:fresh --seed
