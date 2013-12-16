<?php namespace Pingpong\Videocontest;

use Illuminate\Support\ServiceProvider;
use View;

class VideocontestServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('pingpong/videocontest', 'Videocontest');
    	include __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['videocontest'] = $this->app->share(function($app)
		{
			return new Videocontest;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Videocontest', 'Pingpong\Videocontest\Facades\Videocontest');
			$loader->alias('AppController', 'Pingpong\Videocontest\AppController');
			$loader->alias('Twitter', '\TwitterOAuth\Api');
		});
		View::addNamespace('themes', base_path().'/themes/');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('videocontest');
	}

}