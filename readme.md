Beehive-web
===========

Web application and REST API for the Beehive platform

# Front-end development (Structure)
frontend
|--- css (all scss files)
|--- js
     |--- module 1
     |--- module 2
     |--- module n

All scss will be compiled and concatenated and copied to public/assets/css
All javascript files for each module will be concatenated and copied to public/assets/js as public/assets/js/module1.min.js public/assets/js/module2.min.js, etc.

For vendor libraries such as angularjs, bootstrap, jquery, etc. They will be included in public/assets/vendors/[css|js|img|fonts]

# Front-end development (Requirements)
+ NodeJS and Node Package Manager installed
+ Global Grunt installed
+ Sass and Compass

In order to install dependencies run:
###
$ npm install
###

For development, you must configure Gruntfile.js. In order to execute tasks for compile, watch, etc. run:
###
$ grunt
###

# Run the application
As the web application runs over Laravel, you must have installed composer. To install all Laravel and required libraries run:
###
$ composer install
###

To run the application in Laravel's testing server run:
###
$ ./artisan serve
###

# Set Environment
This application reads "LARAVEL_ENV" environment variable and by default it is set to "local", so you must create local configurations i.e. app/config/local/[app.php, database.php, etc.]
