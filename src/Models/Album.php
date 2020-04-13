<?php

namespace FaithGen\Gallery\Models;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\CommentableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;
use FaithGen\SDK\Traits\TitleTrait;

class Album extends UuidModel
{
    use  ImageableTrait, BelongsToMinistryTrait, StorageTrait, TitleTrait, CommentableTrait;

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//
    public function getNameAttribute($val)
    {
        return ucwords($val);
    }

    //****************************************************************************//
    //***************************** MODEL RELATIONSHIPS *****************************//
    //****************************************************************************//

    /**
     * The name of the directory in storage that has files for this model.
     * @return mixed
     */
    public function filesDir()
    {
        return 'gallery';
    }

    /**
     * The file name fo this model.
     * @return mixed
     */
    public function getFileName()
    {
        return $this->images()->pluck('name')->toArray();
    }

    public function getImageDimensions()
    {
        return [0, 100];
    }
}
