<?php

namespace FaithGen\Gallery\Jobs\ImageSaved;

use FaithGen\SDK\Models\Image;
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
        SerializesModels;

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
        $ogImage = storage_path('app/public/gallery/original/').$this->image->name;
        $thumb100 = storage_path('app/public/gallery/100-100/').$this->image->name;

        $imageManager->make($ogImage)->fit(100, 100, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        }, 'center')->save($thumb100);
    }
}
