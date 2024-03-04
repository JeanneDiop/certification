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
            // 'historiuevente_id' => 'required|integer',
            'montantVerser' => 'required|numeric|gt:0',
            'etat' => 'required|in:comptant,acompte', // Ajoutez la validation pour 'comptant' ou 'acompte'
        ];
    }
    
    public function messages()
    {
        return [
            // 'historiquevente_id.required' => 'Le champ vente_id est requis.',
            'montantVerser.required' => 'Le champ montantVerser est requis.',
            'montantVerser.numeric' => 'Le champ montantVerser doit être un nombre.',
            'montantVerser.gt' => 'Le champ montantVerser doit être supérieur à zéro ca exclut les valeurs negatifs.',
            'etat.required' => 'Le champ état est requis.',
            'etat.in' => 'Le champ état doit être soit "comptant" soit "acompte".',
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