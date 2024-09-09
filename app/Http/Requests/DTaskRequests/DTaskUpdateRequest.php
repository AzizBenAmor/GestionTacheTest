<?php

namespace App\Http\Requests\DTaskRequests;

use App\Models\DTask;
use Illuminate\Foundation\Http\FormRequest;

class DTaskUpdateRequest extends FormRequest
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
            'status'=>'nullable|exists:p_task_states,status',
            'date'=>'nullable|date|before_or_equal:today',
            'title'=>'nullable|string',
            'description'=>'nullable|string',
            'users'=>'array|nullable',
            'users.*'=>'required|exists:users,id'
        ];
    }
}
