<?php

namespace App\Http\Requests\Facture;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'numerofacture' => [
                'required',
                'regex:/^[A-Z]{2}\d{5}$/'
            ],
            'payement_id' => 'integer|required',
        ];
    }

    public function messages()
    {
        return [
            'numerofacture.required' => 'Le champ numerofacture est requis.',
            'numerofacture.regex' => 'Le champ numerofacture doit contenir deux lettres majuscules suivies de cinq chiffres.',
            'payement_id.integer' => 'Le champ "payement_id" doit être un entier.',
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
