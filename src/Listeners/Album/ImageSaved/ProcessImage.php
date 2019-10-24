<?php

namespace FaithGen\Gallery\Listeners\Album\ImageSaved;

use FaithGen\Gallery\Events\Album\ImageSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * Create the event listener.
     *
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Handle the event.
     *
     * @param ImageSaved $event
     * @return void
     */
    public function handle(ImageSaved $event)
    {
        $ogImage = storage_path('app/public/gallery/original/') . $event->getImage()->name;
        $thumb100 = storage_path('app/public/gallery/100-100/') . $event->getImage()->name;

        $this->imageManager->make($ogImage)->fit(100, 100, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        }, 'center')->save($thumb100);
    }
}
