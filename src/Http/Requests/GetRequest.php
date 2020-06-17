<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\Gallery\Services\AlbumService;
use FaithGen\SDK\Models\Ministry;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
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
        if (auth()->user() instanceof Ministry) {
            return $this->user()->can('view', $albumService->getAlbum());
        }

        return true;
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
        throw new AuthorizationException('You do not have access to this album');
    }
}
