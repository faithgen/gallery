<?php

namespace FaithGen\Gallery\Helpers;

use FaithGen\Gallery\Models\Album;
use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Image;
use FaithGen\SDK\SDK;

class AlbumHelper extends Helper
{
    public static $freeAlbumsCount = 1;
    public static $freeAlbumImagesCount = 10;
    public static $premiumAlbumsCount = 5;
    public static $premiumAlbumImagesCount = 20;
}
