<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\Gallery\Helpers\AlbumHelper;
use FaithGen\Gallery\Services\AlbumService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class AddImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(AlbumService $albumService)
    {
        return $this->user()->can('addImages', $albumService->getAlbum());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'images' => 'required|image',
            // 'images' => 'required|array',
            // 'images.*' => 'required|base64image',
            'album_id' => AlbumHelper::$idValidation
        ];
    }

    protected function failedAuthorization()
    {
        if (strcmp(auth()->user()->account->level, 'Free') === 0)
            $message = 'You need to upgrade to able to add more than 10 images to this album month';
        else
            $message = 'You need to upgrade to able to add more than 20 images to this album month';
        throw new AuthorizationException($message, 403);
    }
}
