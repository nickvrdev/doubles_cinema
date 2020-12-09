This is the "Doubles Cinema Experience" built on Laravel 8

#Getting started

1) Clone this repository to a host which supports Laravel 8
https://laravel.com/docs/8.x/deployment#server-requirements

2) Run `composer update` from the base directory to load all the required dependencies.

3) Create a database on MySQL and update the .env DB connections details and while you're there you might as well give your website cinema a snazzy name

4) In order to populate the database use the command from the base directory `php artisan migrate:refresh --seed`
This will rollback all migrations, insert all migrations and also seed the database with data.

#Description of tools and frameworks used

Laravel as a framework since it has all the required functionality for the task from easy to add authentication, bootstrap for styling, jQuery for javascript. I originally looked at Lumen but decided against using it since it doesn't have all the functionality I needed.

Using the Eloquent model classes with relationships made it easy to link all the database items together, as well as retrieving and serving the data to the end user.

Using the Migrations tool I was able to construct the database quickly using the methods available to create tables, fields and keys. Seeding the database with data was also easy to implement using the migration seed script DatabaseSeeder.php (more complex systems can take advantage of multiple seed scripts)

I used the built in layout and theme from the Laravel UI as the base for the frontend view. I also used jQuery AJAX functions to pull data from the database without exposing all the data in a javascript object.

#Next version

I would have used more session data to store a "cart" of the users ticket selections but decided this was a "nice-to-have" feature as well as better error handling and user experience.
Introduce fair use policy so that all users get fair share access to tickets.
