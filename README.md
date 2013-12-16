PiNGPONG Video Contest
============

Laravel Package for Create Video Contest App. This package is support for Laravel 4 or higher.

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

3. Next, do `composer install` on your terminal.
4. After the installation complete. Copy `seeds` and `migrations` folder to `app/database/` folder.
5. Run:
 - `php artisan migrate`
 - `php artisan db:seed`
6. Last, add new provider 'Pingpong\Videocontest\VideocontestServiceProvider' to providers array on 'app/config/app.php'
7. Finish. Test run `php artisan serve`. Open `http://localhost:8000/` on your browser. 


Developer
---------
[Gravitano](https://github.com/gravitano)
