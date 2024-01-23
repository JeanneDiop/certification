<?php

namespace App\Http\Requests\ProduitAchat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProduitAchatRequest extends FormRequest
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
           
            'quantité_achat' => 'required|numeric',
            'produit_id' => 'required|integer',
            'achat_id' => 'required|integer',
        ];
    }
    
    public function messages()
    {
        return [
           
            'quantité_achat.numeric' => 'Le champ quantité_achat doit être un nombre.',
            'produit_id.integer' => 'Le champ produit_id doit être un entier.',
            'achat_id.integer' => 'Le champ achat_id doit être un entier.'
        ];
    }
    

    protected function failedValidation(Validator $validator)
    {
        // Si la validation échoue, vous pouvez accéder aux erreurs
        $errors = $validator->errors()->toArray();

        // Retournez les erreurs dans la réponse JSON
        throw new HttpResponseException(response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}