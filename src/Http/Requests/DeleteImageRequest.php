<?php

namespace FaithGen\Gallery\Http\Requests\Album;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\Gallery\Models\Album;
use Illuminate\Foundation\Http\FormRequest;

class DeleteImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::findOrFail(request()->album_id);
        return $this->user()->can('album.delete', $album);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_id' => Helper::$idValidation,
            'image_id' => Helper::$idValidation,
        ];
    }
}
