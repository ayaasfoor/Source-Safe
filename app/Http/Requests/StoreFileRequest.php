<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //'name'            =>     'required|min:4|max:255',
            //'file'            =>     'required|file|mimes:png,jpg,pdf,xml,txt',
            //'group_id'       =>     'numeric|exists:groups,id|nullable',
           // 'status'          =>     'required|in:constrine,free'
        ];
    }
}