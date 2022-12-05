<?php

namespace SmartyStudio\LaravelMenu\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use SmartyStudio\LaravelMenu\Menu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require  __DIR__ . '/../../routes/web.php';
        }

        $this->loadViewsFrom(__DIR__ . '/../../../', 'smartystudio/laravelmenu');
        
        $this->publishes([__DIR__ . '/../../config/Laravelmenu.php'  => config_path('menu.php'),], 'config');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/smartystudio/laravelmenu'),], 'views');
        $this->publishes([__DIR__ . '/../../public' => public_path('vendor/smartystudio/laravelmenu'),], 'public');
        $this->publishes([
            __DIR__ . '/../../database/migrations/2017_08_11_073824_create_menus_table.php' => database_path('migrations/2017_08_11_073824_create_menus_table.php'),
            __DIR__ . '/../../database/migrations/2017_08_11_074006_create_menu_items_table.php' => database_path('migrations/2017_08_11_074006_create_menu_items_table.php'),
            __DIR__ . '/../../database/migrations/2019_01_05_293551_add_role_id_to_menu_items_table.php' => database_path('migrations/2019_01_05_293551_add_role_id_to_menu_items_table.php'),
            __DIR__ . '/../../database/migrations/2022_07_06_000123_add_class_to_menu_table.php' => database_path('migrations/2022_07_15_000123_add_class_to_menu_table.php'),
        ], 'migrations');
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

        $this->app->make('SmartyStudio\LaravelMenu\Http\Controllers\MenuController');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravelmenu.php', 'laravelmenu');
    }

    protected function migrationExists($mgr)
    {
        $path = database_path('migrations/');
        $files = scandir($path);
        $pos = false;
        
        foreach ($files as &$value) {
            $pos = strpos($value, $mgr);
            if ($pos !== false) return true;
        }

        return false;
    }
}
