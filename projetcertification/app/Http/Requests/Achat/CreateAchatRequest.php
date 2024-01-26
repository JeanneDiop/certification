<?php

namespace App\Http\Requests\Achat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAchatRequest extends FormRequest
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
            'prixachat' => 'required|numeric', 
            'quantiteachat' => 'required|numeric',
            'nomachat' => 'required|string', 
            'produit_id' => 'required|integer', 
        ];
    }
    
    public function messages()
    {
        return [
            'quantiteachat.required' => 'Le champ "quantiteachat" est obligatoire.',
            'quantiteachat.numeric' => 'Le champ "quantiteachat" doit être un nombre (entier ou décimal).',
            'prixachat.required' => 'Le champ "Prix d\'achat" est obligatoire.',
            'prixachat.numeric' => 'Le champ "Prix d\'achat" doit être un nombre (entier ou décimal).',
            'nomachat.required' => 'Le champ "Nomachat" est obligatoire.',
            'nomachat.string' => 'Le champ "Nomachat" doit être une chaîne de caractères.',
            'produit_id.required' => 'Le champ "Produit ID" est obligatoire.',
            'produit_id.integer' => 'Le champ "Produit ID" doit être un entier.',
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