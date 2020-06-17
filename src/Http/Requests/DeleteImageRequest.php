<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\Gallery\Services\AlbumService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class DeleteImageRequest extends FormRequest
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
        return $this->user()->can('delete', $albumService->getAlbum());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this image');
    }
}
