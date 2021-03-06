<?php

namespace FaithGen\Gallery\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class Image extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'caption'  => $this->caption,
            'comments' => $this->comments()->count(),
            'avatar'   => ImageHelper::getImage('gallery', $this->resource, config('faithgen-sdk.ministries-server')),
            'date'     => Helper::getDates($this->created_at),
        ];
    }
}
