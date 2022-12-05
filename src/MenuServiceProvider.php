<?php

namespace SmartyStudio\LaravelMenu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use SmartyStudio\LaravelMenu\Helpers\Menu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Routes
        if (!$this->app->routesAreCached()) {
            include __DIR__ . '/routes/web.php';
        }

        // Loading migrations and views
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'laravelmenu');

        // Publishing all the necessary configuration files
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/config/laravelmenu.php'  => config_path('laravelmenu.php'),], 'config');
        }
        
        // Publish all the migrations and assets (migrations, seeders, lang, views, assets)
        $this->publishes([__DIR__ . '/database/migrations/' => database_path('migrations')], 'migrations');
        $this->publishes([__DIR__ . '/resources/views' => resource_path('views/vendor/smartystudio/laravelmenu'),], 'views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('menu', function () {
            return new Menu();
        });

        // Register LaravelMenu helper class
        $this->app->singleton('menu', 'SmartyStudio\LaravelMenu\Helpers\Menu');

        $this->app->make('SmartyStudio\LaravelMenu\Http\Controllers\MenuController');
    }
}
