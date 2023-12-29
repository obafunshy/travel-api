<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
   public function test_login_returns_token_with_valid_credentials()
   {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);

   }

   public function test_login_returns_error_with_invalid_credentials()
   {
       $response = $this->postJson('/api/v1/login',
            [
                'email' => 'nonexisting@user.com',
                'password' => 'password',
            ]
        );

        $response->assertStatus(422);

   }

}
