<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title field may not be greater than :max characters.',
            'body.required' => 'The body field is required.'
        ];
    }
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required'
        ];
    }

}