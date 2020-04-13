<?php

namespace FaithGen\Gallery\Traits;

use FaithGen\Gallery\Models\Album;

trait HasManyAlbums
{
    /**
     * Links many albums to a model.
     * @return mixed
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
