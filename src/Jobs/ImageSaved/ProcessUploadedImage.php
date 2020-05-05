<?php

namespace FaithGen\Gallery\Jobs\ImageSaved;

use FaithGen\SDK\Models\Image;
use FaithGen\SDK\Traits\ProcessesImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class ProcessUploadedImage implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        ProcessesImages;

    public bool $deleteWhenMissingModels = true;
    protected Image $image;

    /**
     * Create a new job instance.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @param ImageManager $imageManager
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        $this->processImage($imageManager, $this->image);
    }
}
