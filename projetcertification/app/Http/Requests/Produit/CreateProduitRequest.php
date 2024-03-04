<?php

namespace App\Http\Requests\Produit;



use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProduitRequest extends FormRequest
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
            'prixU' => 'required|numeric|gt:0',
            'quantite' => 'required|numeric|gt:0',
            'quantiteseuil' => 'required|numeric|gt:0',
            // 'etat' => ['required', 'in:en_stock,rupture,critique,en_cours,terminé'], // Utilisation de 'in' pour le type enum
            'categorie_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'nomproduit.required' => 'Le champ nom du produit est requis.',
            'image.required' => 'Le champ image est requis.',
            'prixU.required' => 'Le champ prix unitaire est requis.',
            'prixU.numeric' => 'Le champ prix unitaire doit être un nombre.',
            'prixU.gt' => 'Le champ prix unitaire doit être supérieur à zéro ca exclut les valeurs negatifs.',
            'quantite.required' => 'Le champ quantité est requis.',
            'quantite.numeric' => 'Le champ quantité doit être un nombre.',
            'quantite.gt' => 'Le champ quantité doit être supérieur à zéro ca exclut les valeurs negatifs.',
            'quantiteseuil.required' => 'Le champ quantité seuil est requis.',
            'quantiteseuil.numeric' => 'Le champ quantité seuil doit être un nombre.',
            'quantiteseuil.gt' => 'Le champ quantité seuil doit être supérieur à zéro ca exclut les valeurs negatifs.',
            'categorie_id.required' => 'Le champ catégorie est requis.',
            'categorie_id.integer' => 'Le champ catégorie doit être un entier.'
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
