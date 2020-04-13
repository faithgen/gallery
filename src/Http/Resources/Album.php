<?php

namespace FaithGen\Gallery\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class Album extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'comments' => $this->comments()->count(),
            'date' => Helper::getDates($this->created_at),
            'images' => [
                'count' => $this->images()->count(),
            ],
            'avatar' => ImageHelper::getImage('gallery', $this->images()->latest()->first(), config('faithgen-sdk.ministries-server')),
        ];
    }
}
