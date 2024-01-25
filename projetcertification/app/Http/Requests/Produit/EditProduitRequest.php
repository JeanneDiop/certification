<?php

namespace App\Http\Requests\Produit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditProduitRequest extends FormRequest
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
            'nomproduit' => 'required|string|max:255',
            'image' => 'required|string',
            'prixU' => 'required|numeric',
            'quantité' => 'required|numeric',
            'quantitéseuil' => 'required|numeric',
            'etat' => ['required', 'in:en stock,rupture,critique,en cours,terminé'],
            'categorie_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
       'nomproduit.required' => 'Le champ nomproduit est requis.',
        'image.required' => 'Le champ image est requis.',
        'prixU.numeric' => 'Le champ prixU doit être un nombre.',
        'quantité.numeric' => 'Le champ quantité doit être un nombre.',
        'quantitéseuil.numeric' => 'Le champ quantité doit être un nombre.',
        'etat.in' => 'La valeur du champ état n\'est pas valide.',
        'categorie_id.integer' => 'Le champ categorie_id doit être un entier.'
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