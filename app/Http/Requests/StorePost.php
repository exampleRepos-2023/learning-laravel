<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'     => 'bail|required|min:5|max:100',
            'content'   => 'required|min:1|max:1000',
            'thumbnail' => 'image|mimes:png,jpg,jpeg,gif,svg|max:1024|dimensions:min_width=200,min_height=200',
        ];
    }
}
