<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare os dados para validação.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Converte o código da máquina para maiúsculas e remove espaços à volta
            'code' => strtoupper(trim($this->code)),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'machine_id' => 'required|exists:machines,id',
            'type' => 'required|in:preventiva,corretiva',
            'priority' => 'required|in:baixa,media,alta,critica',
            'description' => 'required|string|max:1000',
        ];
    }
}
