<?php

namespace FaithGen\Gallery\Http\Requests\Album;

use FaithGen\Gallery\Helpers\AlbumHelper;
use FaithGen\Gallery\Models\Album;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::findOrFail(request()->album_id);
        return $this->user()->can('album.update', $album);
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
}
