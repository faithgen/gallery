<?php

namespace FaithGen\Gallery\Http\Resources;

use FaithGen\Gallery\Helpers\AlbumHelper;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'date' => AlbumHelper::getDates($this->created_at),
            'images' => [
                'count' => $this->images()->count()
            ],
            'avatar' => [
                '_100' => $this->images()->exists() ? AlbumHelper::getAlbumIcon($this->resource, 100) : asset('images/folder.png'),
                'original' => $this->images()->exists() ? AlbumHelper::getAlbumIcon($this->resource) : asset('images/folder.png')
            ]
        ];
    }
}
