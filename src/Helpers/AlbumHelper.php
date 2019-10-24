<?php


namespace FaithGen\Gallery\Helpers;


use FaithGen\Gallery\Models\Ministry\Album;
use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Image;

class AlbumHelper extends Helper
{
    static function getAlbumIcon(Album $album, int $dimen = 0)
    {
        $image = $album->images()->select(['name'])->latest()->first();
        if ($dimen) return asset('storage/gallery/100-100/' . $image->name);
        else return asset('storage/gallery/original/' . $image->name);
    }

    static function getImageLinks(Image $image)
    {
        return [
            'thumb' => asset('storage/gallery/100-100/' . $image->name),
            'original' => asset('storage/gallery/original/' . $image->name),
        ];
    }
}
