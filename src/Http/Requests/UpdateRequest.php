<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\Gallery\Helpers\AlbumHelper;
use FaithGen\Gallery\Services\AlbumService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(AlbumService $albumService)
    {
        return $this->user()->can('update', $albumService->getAlbum());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_id' => AlbumHelper::$idValidation,
            'name' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this album');
    }
}
