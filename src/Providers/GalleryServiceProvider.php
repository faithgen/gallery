<?php

namespace FaithGen\Gallery\Providers;

use App\Observers\Ministry\AlbumObserver;
use FaithGen\Gallery\Models\Album;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
{

    protected $listen = [
        \FaithGen\Gallery\Events\Album\ImageSaved::class => [
            \FaithGen\Gallery\Listeners\Album\ImageSaved\ProcessImage::class,
            \FaithGen\Gallery\Listeners\Album\ImageSaved\S3Upload::class,
        ],
        \FaithGen\Gallery\Events\Album\Created::class => [
            \FaithGen\Gallery\Listeners\Album\Created\MessageFollowUsers::class,
        ],
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/gallery.php');
        $this->publishes([
            __DIR__ . '/../storage/gallery/' => storage_path('app/public/gallery')
        ]);

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
}
