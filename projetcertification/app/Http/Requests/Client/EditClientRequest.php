<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditClientRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'code_client' => 'required|regex:/^[A-Za-z0-9]+$/|max:255',
            'telephone' => ['required', 'regex:/^\+221(77|78|76|70)\d{7}$/'],
            'adresse' => 'required|string|max:255',
        ];
    }
    
    public function messages()
    {
        return [
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prenom est requis.',
            'code_client.regex' => 'Le code client doit contenir des chiffres et des lettres uniquement.',
            'telephone.regex' => 'Le numéro de téléphone doit être au format sénégalais avec le préfixe +221 et suivi de 7chiffres.',
            'adresse.required' => 'Le champ adresse doit etre  requis.',
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