<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
        $rules['email'] = 'bail|required|max:64|unique:admin,email,' . request('id');

        if (!request('id')) {
            $rules['password'] = 'bail|required|min:6|confirmed';
        } else {
            $rules['password_new'] = request('password_new') ? 'bail|min:6|confirmed' : 'bail|confirmed';
        }

        return $rules;
    }
}
