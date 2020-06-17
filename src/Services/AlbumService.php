<?php

namespace FaithGen\Gallery\Services;

use FaithGen\Gallery\Models\Album;
use InnoFlash\LaraStart\Services\CRUDServices;

class AlbumService extends CRUDServices
{
    /**
     * @var Album
     */
    protected Album $album;

    public function __construct()
    {
        $this->album = app(Album::class);

        if (request()->has('album_id')) {
            $this->album = Album::findOrFail(request('album_id'));
        }

        if (request()->route()->hasParameter('album')) {
            $this->album = $this->album->resolveRouteBinding(request()->route('album'));
        }
    }

    /**
     * Retrieves an instance of album.
     *
     * @return \FaithGen\Gallery\Models\Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods.
     * Its mainly the fields that you do not have in the messages table.
     *
     * @return array
     */
    public function getUnsetFields(): array
    {
        return ['album_id'];
    }

    public function getParentRelationship()
    {
        return auth()->user()->albums();
    }
}
