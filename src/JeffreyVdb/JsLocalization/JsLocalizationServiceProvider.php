<?php
namespace JeffreyVdb\JsLocalization;

use App;
use Artisan;
use Config;
use View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use JeffreyVdb\JsLocalization\Commands\RefreshCommand;

class JsLocalizationServiceProvider extends ServiceProvider {

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
		//echo 'BOOTING JEFFREYS SHIZZLE';
		// $this->package('jeffreyvdb/jslocalization');
		//
		// $this->registerNamespaces();
		$this->registerRefreshCommand();
		$this->publishes([
			__DIR__.'/../../../public/js/' => public_path('packages/jeffreyvdb/jslocalization/js'),
		], 'public');

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('js-localization.php')
        ]);

		$this->mergeConfigFrom(
			__DIR__.'/../../config/config.php', 'js-localization'
		);

		$this->loadViewsFrom(__DIR__.'/../views', 'js-localization');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		require __DIR__.'/../../bindings.php';
		require __DIR__.'/../../routes.php';
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['jslocalization'];
	}

	// private function registerNamespaces ()
	// {
	// 	if (File::isDirectory( app_path().'/config/packages/jeffreyvdb/jslocalization' )) {
	// 		Config::addNamespace('jslocalization', app_path().'/config/packages/jeffreyvdb/localization');
	// 	} else {
	// 		Config::addNamespace('jslocalization', __DIR__.'/../../config');
	// 	}
	//
	// 	View::addNamespace('jslocalization', __DIR__ . '/../../views');
	// }

	/**
	 * Register js-localization.refresh
	 */
	private function registerRefreshCommand ()
	{
		$this->app['jslocalization.refresh'] = $this->app->share(function($app)
		{
			return new RefreshCommand;
		});

		$this->commands('jslocalization.refresh');
	}

}
