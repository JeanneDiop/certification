<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Auth_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    // use RefreshDatabase;
    public function test_register(): void

    {
        //Création d'un utilisateur avec une factory
      
        $user = User::factory()->create([
            'telephone' => '+221770510043',
         ]);
        

      
        //Envoi d'une requête HTTP POST vers la route d'enregistrement (api/register) avec les données de l'utilisateur
        $response = $this->json('POST','api/register', $user->toArray());
       //Assertion du statut de la réponse
        $response->assertStatus(200);
   
    }
    public function test_connexion()
    {
        $userexist =User::where('email','diopj@gmail.com')->first();

        $response = $this->postJson('api/login',[
            'email' => 'diopj@gmail.com',
            'password' => 'azerty12',
           
        ]);
         //verification
        $response->assertStatus(200);
    }

    public function test_deconnexion()
    {
    
            // Rechercher l'utilisateur
            $user = User::where('email', 'diopj@gmail.com')->first();
            if (!$user) {
                $this->fail('Utilisateur non trouvé');
            }
        
            // Connexion de l'utilisateur avec le token JWT
            $token = auth('api')->login($user);
        
            // Effectuer une demande de déconnexion avec le token
            $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/logout');
        
            // Assurer que la déconnexion a réussi
            $response->assertStatus(200);
        
            // Assurer que l'utilisateur est maintenant un invité (non authentifié)
            $this->assertGuest();
        }
        

}
