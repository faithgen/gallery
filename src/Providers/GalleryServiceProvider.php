<?php

namespace FaithGen\Gallery\Providers;

use FaithGen\Gallery\Models\Album;
use FaithGen\Gallery\Observers\Ministry\AlbumObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-gallery.php', 'faithgen-gallery');

        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/faithgen-gallery.php' => config_path('faithgen-gallery.php'),
            ], 'faithgen-gallery-config');

            if (config('faithgen-sdk.source')) {
                $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
                $this->publishes([
                    __DIR__ . '/../storage/gallery/' => storage_path('app/public/gallery')
                ]);

                $this->publishes([
                    __DIR__ . '/../database/migrations/' => database_path('migrations'),
                ], 'faithgen-gallery-migrations');
            }
        }
        Album::observe(AlbumObserver::class);
    }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/gallery.php');
            if (config('faithgen-sdk.source'))
                $this->loadRoutesFrom(__DIR__ . '/../routes/source.php');
        });
    }

    private function routeConfiguration()
    {
        return [
            'prefix' => config('faithgen-gallery.prefix'),
            'namespace' => "FaithGen\Gallery\Http\Controllers",
            'middleware' => config('faithgen-gallery.middlewares'),
        ];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
