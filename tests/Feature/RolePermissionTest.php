<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear permisos básicos
        Permission::create(['name' => 'ViewAny:User']);
        Permission::create(['name' => 'Update:User']);
        Permission::create(['name' => 'ViewAny:Role']);
        
        // Crear roles
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'Usuario']);
        Role::create(['name' => 'Visor']);
        Role::create(['name' => 'Editor']);
    }

    /** @test */
    public function super_admin_has_all_permissions()
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');
        
        $role = Role::findByName('super_admin');
        $role->givePermissionTo(Permission::all());
        
        $this->assertTrue($superAdmin->can('ViewAny:User'));
        $this->assertTrue($superAdmin->can('Update:User'));
        $this->assertTrue($superAdmin->can('ViewAny:Role'));
    }

    /** @test */
    public function viewer_can_only_view_users()
    {
        $viewer = User::factory()->create();
        $viewer->assignRole('Visor');
        
        $role = Role::findByName('Visor');
        $role->givePermissionTo(['ViewAny:User']);
        
        $this->assertTrue($viewer->can('ViewAny:User'));
        $this->assertFalse($viewer->can('Update:User'));
        $this->assertFalse($viewer->can('ViewAny:Role'));
    }

    /** @test */
    public function editor_can_view_and_edit_users()
    {
        $editor = User::factory()->create();
        $editor->assignRole('Editor');
        
        $role = Role::findByName('Editor');
        $role->givePermissionTo(['ViewAny:User', 'Update:User']);
        
        $this->assertTrue($editor->can('ViewAny:User'));
        $this->assertTrue($editor->can('Update:User'));
        $this->assertFalse($editor->can('ViewAny:Role'));
    }

    /** @test */
    public function usuario_has_no_special_permissions()
    {
        $usuario = User::factory()->create();
        $usuario->assignRole('Usuario');
        
        $this->assertFalse($usuario->can('ViewAny:User'));
        $this->assertFalse($usuario->can('Update:User'));
        $this->assertFalse($usuario->can('ViewAny:Role'));
    }

    /** @test */
    public function user_can_access_panel_based_on_role()
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');
        
        $usuario = User::factory()->create();
        $usuario->assignRole('Usuario');
        
        // Ambos pueden acceder al panel (según nuestra lógica)
        $this->assertTrue($superAdmin->canAccessPanel(null));
        $this->assertTrue($usuario->canAccessPanel(null));
    }
}
