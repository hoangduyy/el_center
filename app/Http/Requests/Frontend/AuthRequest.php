<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        $id = request('id');

        $rule = [
            'email' => 'unique:user,email,' . $id,
            'phone' => 'bail|digits:10|unique:user,phone,' . $id,
        ];

        if (!$id) {
            // for create
            $rule['password'] = 'required|min:6|confirmed';
        } else {
            $tmp = 'nullable|confirmed';
            if (request()) {
                $tmp .= '|min:6';
            }
            $rule['password_new'] = $tmp;
        }

        return $rule;
    }
}
