<?php

namespace App\Observers\Ministry;

use App\Events\Album\Created;
use FaithGen\Gallery\Models\Album;
use FaithGen\SDK\Traits\FileTraits;
use Illuminate\Support\Facades\DB;

class AlbumObserver
{
    use FileTraits;

    /**
     * Handle the album "created" event.
     *
     * @param \App\Models\Ministry\Album $album
     * @return void
     */
    public function created(Album $album)
    {
        event(new Created($album));
    }

    /**
     * Handle the album "updated" event.
     *
     * @param \App\Models\Ministry\Album $album
     * @return void
     */
    public function updated(Album $album)
    {
        //
    }

    /**
     * Handle the album "deleted" event.
     *
     * @param \App\Models\Ministry\Album $album
     * @return void
     */
    public function deleted(Album $album)
    {
        if ($album->images()->exists()) {
            $this->deleteFiles($album);
            $imageIds = $album->images()->pluck('id')->toArray();
            DB::table('images')->whereIn('id', $imageIds)->delete();
        }
    }

    /**
     * Handle the album "restored" event.
     *
     * @param \App\Models\Ministry\Album $album
     * @return void
     */
    public function restored(Album $album)
    {
        //
    }

    /**
     * Handle the album "force deleted" event.
     *
     * @param \App\Models\Ministry\Album $album
     * @return void
     */
    public function forceDeleted(Album $album)
    {
        //
    }
}
