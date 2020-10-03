<?php
namespace Shibaji\Admin;


use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Shibaji\Admin\Components\Alert;
use Shibaji\Admin\Components\Notification;
use Shibaji\Admin\Components\Search;
use Shibaji\Admin\Components\Shortcuts;
use Shibaji\Admin\Components\Translate;
use Shibaji\Admin\Console\Commands\Admin;
use Shibaji\Admin\Console\Commands\AdminPub;

// require_once( __DIR__ . '/helpers/utilities.php');

class AdminServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/admin.php', 'admin'
        );
    }

    public function boot(){
        Schema::defaultStringLength(191);


        // $lf = new LeftMenu();

        // $lf->append('app', [
        //     'link' => '',
        //     'label' => 'App Test Menu',
        //     'child' => [
        //         [
        //             'link' => '#Test',
        //             'label' => 'Test Submenu'
        //         ]
        //     ]
        // ]);

        // $this->loadFactoriesFrom(__DIR__.'/database/factories');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'admin');
        $this->loadTranslationsFrom(__DIR__.'/resources/translations', 'admin');
        $this->loadViewComponentsAs('admin', [
            Alert::class,
            Search::class,
            Shortcuts::class,
            Translate::class,
            Notification::class
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                Admin::class,
                AdminPub::class,
            ]);
        }
        // Template Variables
        view()->share('assetLink', config('admin.assets', 'assets'));
        // view()->share('user', Auth::user()); // Not working

        $this->resources();

    }

    private function resources(){
        // Resource Shareing to the public
        $this->publishes([
            // __DIR__.'/resources' => public_path(config('admin.assets', 'assets')),
            __DIR__.'/resources/public' => public_path('/'),
        ], 'admin-assets');

        $this->publishes([
            __DIR__.'/config/admin.php' => config_path('admin.php'),
        ], 'admin-config');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'admin-migration');

        $this->publishes([
            __DIR__.'/database/factories/' => database_path('factories'),
        ], 'admin-migration');

        $this->publishes([
            __DIR__.'/database/seeds/' => database_path('seeds'),
        ], 'admin-seeds');

        $this->publishes([
            __DIR__.'/resources/translations' => resource_path('lang/vendor/courier'),
        ], 'admin-trans');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/admin'),
        ], 'admin-views');

        // Partial Discover Resources
        $this->publishes([
            __DIR__.'/resources/views/dashboard' => resource_path('views/vendor/admin/dashboard'),
        ], 'admin-views-dashboard');

        $this->publishes([
            __DIR__.'/resources/views/pages' => resource_path('views/vendor/admin/pages'),
        ], 'admin-views-pages');

        $this->publishes([
            __DIR__.'/resources/views/seo' => resource_path('views/vendor/admin/seo'),
        ], 'admin-views-seo');
    }
}
