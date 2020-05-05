<?php

namespace FaithGen\Gallery\Jobs\ImageSaved;

use FaithGen\SDK\Models\Image;
use FaithGen\SDK\Traits\SavesToAmazonS3;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class S3Upload implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        SavesToAmazonS3;

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
    public function handle()
    {
        try {
            $this->saveFiles($this->image);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
