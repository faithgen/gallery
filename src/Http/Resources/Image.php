<?php

namespace FaithGen\Gallery\Http\Resources;

use FaithGen\Gallery\Helpers\AlbumHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'caption' => $this->caption,
            'avatar' => AlbumHelper::getImageLinks($this->resource),
            'date' => AlbumHelper::getDates($this->created_at)
        ];
    }
}
