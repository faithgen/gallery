<?php

namespace FaithGen\Gallery\Http\Requests;

use FaithGen\Gallery\Models\Album;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Album::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ];
    }

    protected function failedAuthorization()
    {
        if (strcmp(auth()->user()->account->level, 'Free') === 0)
            $message = 'You need to upgrade to able to create more than one album this month';
        else $message = 'You need to upgrade further to be able to create more than 5 albums this month';
        throw new AuthorizationException($message, 403);
    }
}
