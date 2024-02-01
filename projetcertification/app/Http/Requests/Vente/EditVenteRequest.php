<?php

namespace App\Http\Requests\Vente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        //    'quantite_vendu' => 'required|numeric',
            // 'produit_id' => 'required|integer',
            'client_id' => 'required|integer',
            // 'user_id' => 'required|integer',
        ];
    }
    
    public function messages()
    {
        return [
            // 'quantite_vendu.required' => 'Le champ quantite_vendu est requis.',
            // 'quantite_vendu.numeric' => 'Le champ quantite_vendu doit être un nombre.',
            // 'produit_id.required' => 'Le champ produit_id est requis.',
            // 'produit_id.integer' => 'Le champ produit_id doit être un entier.',
            'client_id.required' => 'Le champ client_id est requis.',
            'client_id.integer' => 'Le champ client_id doit être un entier.',
            // 'user_id.integer' => 'Le champ user_id doit être un entier.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Si la validation échoue, vous pouvez accéder aux erreurs
        $errors = $validator->errors()->toArray();

        // Retournez les erreurs dans la réponse JSON
        throw new HttpResponseException(response()->json(['errors' => $errors] ,JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}