<?php

namespace App\Http\Requests\Admin\Academics;

use Illuminate\Foundation\Http\FormRequest;

class SmAssignClassTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'class' => "required",
            'section' => "required",
            'teacher' => "required",
        ];
    }
    
    public function messages()
    {
        return [
            'teacher.required' => 'The lecturer field is required.',
        ];
    }
}
