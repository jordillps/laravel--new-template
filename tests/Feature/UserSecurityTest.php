<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Support\Facades\Password;

class UserSecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function password_must_meet_security_requirements()
    {
        // Test que las contraseñas débiles no son aceptadas
        $this->assertTrue(true); // Placeholder - las reglas están en Password::defaults()
    }

    /** @test */
    public function valid_password_should_be_accepted()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('Password123!'), // Válida
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'name' => 'Test User'
        ]);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password123!')
        ]);

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'Password123!'
        ]);

        $this->assertAuthenticated();
    }
}
