<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function user_can_have_avatar_url()
    {
        $user = User::factory()->create([
            'avatar' => 'https://example.com/avatar.jpg'
        ]);

        $this->assertEquals('https://example.com/avatar.jpg', $user->avatar);
    }

    /** @test */
    public function user_avatar_can_be_null()
    {
        $user = User::factory()->create([
            'avatar' => null
        ]);

        $this->assertNull($user->avatar);
    }

    /** @test */
    public function user_has_filament_avatar_url_method()
    {
        $user = User::factory()->create([
            'avatar' => 'https://example.com/avatar.jpg'
        ]);

        $this->assertTrue(method_exists($user, 'getFilamentAvatarUrl'));
        $this->assertEquals('https://example.com/avatar.jpg', $user->getFilamentAvatarUrl());
    }

    /** @test */
    public function user_without_avatar_returns_null_for_filament_avatar()
    {
        $user = User::factory()->create([
            'avatar' => null
        ]);

        $this->assertNull($user->getFilamentAvatarUrl());
    }

    /** @test */
    public function user_model_has_avatar_deletion_methods()
    {
        $user = User::factory()->create();

        // Verificar que los métodos existen
        $this->assertTrue(method_exists($user, 'deleteOldAvatar'));
        $this->assertTrue(method_exists($user, 'isLocalAvatar'));
        $this->assertTrue(method_exists($user, 'getAvatarPath'));
    }

    /** @test */
    public function local_avatar_path_detection_works()
    {
        $user = User::factory()->create([
            'avatar' => 'media/avatars/avatar.jpg'
        ]);

        $this->assertTrue($user->isLocalAvatar());

        $user->avatar = 'https://example.com/avatar.jpg';
        $this->assertFalse($user->isLocalAvatar());
    }
}
