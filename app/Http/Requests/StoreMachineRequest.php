<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMachineRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'section_id'    => 'required|exists:sections,id',
            'code'          => 'required|string|max:255',
            'brand'         => 'required|string|max:255',
            'model'         => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'status'        => 'required|in:operacional,avariada,manutencao',
        ];
    }
}
