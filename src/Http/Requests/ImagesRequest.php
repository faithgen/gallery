<?php

namespace FaithGen\Gallery\Http\Requests\Album;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\Gallery\Models\Album;
use Illuminate\Foundation\Http\FormRequest;

class ImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::findOrFail(request()->album_id);
        return $this->user()->can('album.view', $album);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit' => 'integer|min:1',
            'filter_text' => 'sometimes:string',
            'album_id' => Helper::$idValidation
        ];
    }
}
