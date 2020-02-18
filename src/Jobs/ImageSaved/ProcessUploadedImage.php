<?php
namespace FaithGen\Gallery\Jobs\ImageSaved;

use Illuminate\Bus\Queueable;
use FaithGen\SDK\Models\Image;
use Intervention\Image\ImageManager;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessUploadedImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        $ogImage = storage_path('app/public/gallery/original/') . $this->image->name;
        $thumb100 = storage_path('app/public/gallery/100-100/') . $this->image->name;

        $imageManager->make($ogImage)->fit(100, 100, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        }, 'center')->save($thumb100);
    }
}