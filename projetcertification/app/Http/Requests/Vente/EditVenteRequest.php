<?php

namespace App\Http\Requests\Vente;

use Illuminate\Foundation\Http\FormRequest;

class EditVenteRequest extends FormRequest
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
            'quantité_vendu' => 'required|numeric',
            'montant_total' => 'required|numeric',
            'produit_id' => 'required|integer',
            'client_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }
    
    public function messages()
    {
        return [
            'quantité_vendu.numeric' => 'Le champ quantité vendue doit être un nombre.',
            'montant_total.numeric' => 'Le champ montant total doit être un nombre.',
            'produit_id.integer' => 'Le champ produit_id doit être un entier.',
            'client_id.integer' => 'Le champ client_id doit être un entier.',
            'user_id.integer' => 'Le champ user_id doit être un entier.',
        ];
    }
}