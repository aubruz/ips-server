<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLocationRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'point'         => 'array',
            'point.id'              => 'required_with:point|numeric',
            'wifi'          => 'array',
            'bluetooth'     => 'array',
            'magnetic'      => 'array',
            'wifi.*.rssi'           => 'required_with:wifi|numeric',
            'wifi.*.bssid'          => 'required_with:wifi',
            'bluetooth.*.rssi'      => 'required_with:bluetooth|numeric',
            'bluetooth.*.uuid'      => 'required_with:bluetooth',
            'bluetooth.*.major'     => 'required_with:bluetooth|numeric',
            'bluetooth.*.minor'     => 'required_with:bluetooth|numeric',
            'magnetic.x'            => 'required_with:magnetic|numeric',
            'magnetic.y'            => 'required_with:magnetic|numeric',
            'magnetic.z'            => 'required_with:magnetic|numeric',
            'magnetic.north'        => 'required_with:magnetic|numeric',
            'magnetic.sky'          => 'required_with:magnetic|numeric',
        ];
    }
}
