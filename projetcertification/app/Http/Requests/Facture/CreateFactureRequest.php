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
            'payement_id' => 'required|exists:payements,id',
        ];
    }

    public function messages()
    {
        return [
           'payement_id.integer' => 'Le champ "payement_id" doit être un entier.',
           'payement_id.exists' => 'Ce paiement n\'existe pas'
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
