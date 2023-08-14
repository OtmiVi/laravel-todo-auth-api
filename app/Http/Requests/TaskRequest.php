<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:todo,done',
            'priority' => 'required|in:1,2,3,4,5',
            'title' => 'required|max:256',
            'description' => 'nullable',
            'parent_id' => 'exists:tasks,id',
            'user_id' => 'exists:users,id'
        ];
    }
}
