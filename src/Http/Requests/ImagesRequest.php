<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\Gallery\Services\AlbumService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class ImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param  \FaithGen\Gallery\Services\AlbumService  $albumService
     *
     * @return bool
     */
    public function authorize(AlbumService $albumService)
    {
        return $albumService->getAlbum()
            && $this->user()->can('view', $albumService->getAlbum());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit'       => 'integer|min:1',
            'filter_text' => 'sometimes:string',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to view this album');
    }
}
