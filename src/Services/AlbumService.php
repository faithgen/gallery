<?php


namespace FaithGen\Gallery\Services;


use FaithGen\Gallery\Models\Album;
use FaithGen\SDK\Services\CRUDServices;

class AlbumService extends CRUDServices
{
    /**
     * @var Album
     */
    private $album;

    public function __construct(Album $album)
    {
        if (request()->has('album_id'))
            $this->album = Album::findOrFail(request()->album_id);
        else
            $this->album = $album;
    }

    /**
     * @return Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }


    /**
     * This sets the attributes to be removed from the given set for updating or creating
     * @return mixed
     */
    function getUnsetFields()
    {
        return ['album_id'];
    }

    /**
     * This get the model value or class of the model in the service
     * @return mixed
     */
    function getModel()
    {
        return $this->getAlbum();
    }

    public function getParentRelationship()
    {
        return auth()->user()->albums();
    }
}
