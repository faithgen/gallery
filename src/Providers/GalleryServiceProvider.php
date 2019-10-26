<?php

namespace FaithGen\Gallery\Providers;

use FaithGen\Gallery\Models\Album;
use FaithGen\Gallery\Observers\Ministry\AlbumObserver;
use FaithGen\SDK\Traits\ConfigTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
{
    use ConfigTrait;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-gallery.php', 'faithgen-gallery');

        $this->registerRoutes(__DIR__ . '/../routes/gallery.php', __DIR__ . '/../routes/source.php');

        $this->setUpSourceFiles(function () {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../storage/gallery/' => storage_path('app/public/gallery')
            ]);

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'faithgen-gallery-migrations');
        });

        $this->publishes([
            __DIR__ . '/../config/faithgen-gallery.php' => config_path('faithgen-gallery.php'),
        ], 'faithgen-gallery-config');

        Album::observe(AlbumObserver::class);
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

    /**
     * The config you want to be applied onto your routes
     * @return array the rules eg, middleware, prefix, namespace
     */
    function routeConfiguration(): array
    {
        return [
            'prefix' => config('faithgen-gallery.prefix'),
            'namespace' => "FaithGen\Gallery\Http\Controllers",
            'middleware' => config('faithgen-gallery.middlewares'),
        ];
    }
}
