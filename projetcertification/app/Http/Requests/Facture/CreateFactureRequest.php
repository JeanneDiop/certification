<?php

namespace App\Http\Requests\Facture;

use Illuminate\Foundation\Http\FormRequest;

class CreateFactureRequest extends FormRequest
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
            'numerofacture.required' => 'Le champ "" est obligatoire.',
            'quantiteachat.numeric' => 'Le champ "quantiteachat" doit être un nombre (entier ou décimal).',
            'prixachat.required' => 'Le champ "Prixachat" est obligatoire.',
        ];
    }
}