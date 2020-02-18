<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\SDK\Models\Ministry;
use FaithGen\Gallery\Helpers\AlbumHelper;
use FaithGen\Gallery\Services\AlbumService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class GetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(AlbumService $albumService)
    {
        if (auth()->user() instanceof Ministry) return $this->user()->can('view', $albumService->getAlbum());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_id' => AlbumHelper::$idValidation
        ];
    }

    function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this album');
    }
}
