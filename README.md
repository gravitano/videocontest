PiNGPONG Video Contest App
============

Laravel Package for Create Video Contest App. This package is support for Laravel 4.0 or higher.

Features
---------
1. Login auth using Twitter API.
2. Vote system.
3. Share video  to Facebook and Twitter
4. 1 user just can vote 1 video.
5. Leaderboard Page

Release
--------
This is a frist version of this package. And will be updated soon.

Installation
--------------
1. Download latest of Laravel PHP Framework [here](http://laravel.com)
2. Open your `composer.json`, and add the new require below.

    		"require": {
	    		"laravel/framework": "4.1.*",
	    		// i use ruudk for twitter API
	    		"ruudk/twitter-oauth": "*",
	    		// here is my package
	    		"pingpong/videocontest": "dev-master"
    		},

3. Next, run `composer install` on your terminal.
4. After the installation complete. Copy `seeds` folder from `[your-folder-laravel]/vendor/pingpong/videocontest/src` to `[your-folder-laravel]app/database/` folder.
5. Set yout database configuration on `[your-folder-laravel]/app/config/database.php`. Next, open your terminal and run:
 - `php artisan migrate --package=pingpong/videocontest`
 - `php artisan db:seed`
6. Next, add new provider `Pingpong\Videocontest\VideocontestServiceProvider` to providers array on `[your-folder-laravel]app/config/app.php`
7. Run:
 - `php artisan config:publish pingpong/videocontest`
 - `php artisan asset:publish pingpong/videocontest`
8. For test, run `php artisan serve`. Open `http://localhost:8000/` on your browser. 


Developer
---------
[Gravitano](https://github.com/gravitano)

Note
---------
1. Dont forget to empty default `routes.php` file from laravel on `[your-folder-laravel]/app/routes.php`

Screenshot
--------------
![Screenshot](https://dl.dropboxusercontent.com/s/gvlamkf67ajlj0p/gallery.png)
