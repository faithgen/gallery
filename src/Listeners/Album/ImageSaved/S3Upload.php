<?php

namespace App\Listeners\Album\ImageSaved;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use FaithGen\Gallery\Events\Album\ImageSaved;

class S3Upload implements ShouldQueue
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
