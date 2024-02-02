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
            'quantite' => 'required|numeric',
            'quantiteseuil' => 'required|numeric',
            // 'etat' => ['required', 'in:en_stock,rupture,critique,en_cours,terminé'], // Utilisation de 'in' pour le type enum
            'categorie_id' => 'required|integer',
        ];
    }
    
    public function messages()
    {
        return [
            'nomproduit.required' => 'Le champ nomproduit est requis.',
            'image.required' => 'Le champ image est requis.',
            'prixU.numeric' => 'Le champ prixU doit être un nombre.',
            'quantite.numeric' => 'Le champ quantiteinitiale doit être un nombre.',
            'quantiteseuil.numeric' => 'Le champ quantiteseuil doit être un nombre.',
            // 'etat.in' => 'La valeur du champ état n\'est pas valide.',
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