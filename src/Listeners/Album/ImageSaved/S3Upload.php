<?php

namespace App\Listeners\Album\ImageSaved;

use App\Events\Album\ImageSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class S3Upload
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImageSaved  $event
     * @return void
     */
    public function handle(ImageSaved $event)
    {
        //
    }
}
