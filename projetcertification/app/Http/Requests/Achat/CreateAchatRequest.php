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
            // 'montantachat' => 'required|numeric',
            'quantiteachat' => 'required|numeric|gt:0',
            'nomachat' => 'required|string', 
            'produit_id' => 'required|integer', 
        ];
    }
    
    public function messages()
    {
        return [
            'quantiteachat.required' => 'Le champ "quantiteachat" est obligatoire.',
            'quantiteachat.numeric' => 'Le champ "quantiteachat" doit être un nombre (entier ou décimal).',
            'quantiteachat.gt' => 'Le champ quantiteachat doit être supérieur à zéro ca exclut les valeurs negatifs.',
            'prixachat.required' => 'Le champ "prixachat" est obligatoire.',
            'prixachat.numeric' => 'Le champ "prixachat" doit être un nombre (entier ou décimal).',
            // 'montantachat.required' => 'Le champ "montantachat" est obligatoire.',
            // 'montantachat.numeric' => 'Le champ "montantachat" doit être un nombre (entier ou décimal).',
            'nomachat.required' => 'Le champ "nomachat" est obligatoire.',
            'nomachat.string' => 'Le champ "nomachat" doit être une chaîne de caractères.',
            'produit_id.required' => 'Le champ "produit_id" est obligatoire.',
            'produit_id.integer' => 'Le champ "produit_id" doit être un entier.',
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