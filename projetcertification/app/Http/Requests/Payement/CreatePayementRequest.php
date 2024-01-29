<?php

namespace App\Http\Requests\Payement;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePayementRequest extends FormRequest
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
            'vente_id' => 'required|string',
            'montant_payement' => 'required|numeric',
            
          
        ];
    }
    
    public function messages()
    {
        return [
            'vente_id.required' => 'Le champ vente_id est requis.',
            'montant_payement.required' => 'Le champ montant payement est requis.',
            'montant_payement.numeric' => 'Le champ montant payement doit être un nombre.',
        
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