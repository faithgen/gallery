<?php


namespace FaithGen\Gallery\Helpers;


use FaithGen\Gallery\Models\Album;
use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Image;

class AlbumHelper extends Helper
{
    public static $freeAlbumsCount = 1;
    public static $freeAlbumImagesCount = 10;
    public static $premiumAlbumsCount = 5;
    public static $premiumAlbumImagesCount = 20;

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
