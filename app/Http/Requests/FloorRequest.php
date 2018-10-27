<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FloorRequest extends FormRequest
{
    protected $rules = [
        'name'      => 'max:255',
        'width'     => 'numeric',
        'height'    => 'numeric',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return null|array
     */
    public function rules()
    {
        return $this->rules;
    }
}
