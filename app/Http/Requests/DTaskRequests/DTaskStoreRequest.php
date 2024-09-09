<?php

namespace App\Http\Requests\DTaskRequests;

use Illuminate\Foundation\Http\FormRequest;

class DTaskStoreRequest extends FormRequest
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
            'title'=>'required|string',
            'description'=>'nullable|string',
            'date'=>'required|date|after_or_equal:today',
            'users'=>'array|required',
            'users.*'=>'required|exists:users,id'
        ];
    }
}
