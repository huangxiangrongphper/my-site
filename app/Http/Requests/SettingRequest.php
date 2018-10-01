<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'city' => 'required',
            'bio'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'city' => '城市信息不能为空',
            'bio'  => '个人简介不能为空',
        ];
    }
}
