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
    use RefreshDatabase;
    public function test_connexion()
    {
        $userexist =User::where('email','khady@gmail.com')->first();

        $response = $this->postJson('api/login',[
            'email' => 'khady@gmail.com',
            'password' => 'azerty'
        ]);
         //verification
        $response->assertStatus(200);
    }

    public function test_deconnexion()
    {
    
            // Rechercher l'utilisateur
            $user = User::where('email', 'khady@gmail.com')->first();
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
