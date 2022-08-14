<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        $rules = [
            'degree_id' => 'bail|required',
            'email' => 'bail|required|max:64|unique:teacher,email,' . request('teacher_id'),
            'phone' => 'bail|required|numeric|digits:10|unique:teacher,phone,' . request('teacher_id'),
        ];

        return $rules;
    }
}
