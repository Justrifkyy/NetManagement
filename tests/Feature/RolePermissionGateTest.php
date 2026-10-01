<?php

namespace Tests\Feature;

use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RolePermissionGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_bypasses_all_permission_checks(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->actingAs($superAdmin);

        $this->assertTrue(Gate::allows('any.arbitrary.permission'));
        $this->assertTrue($superAdmin->hasPermission('any.arbitrary.permission'));
    }

    public function test_staff_role_permission_is_enforced_via_gate_and_model(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        RolePermission::create([
            'role' => 'admin',
            'permission' => 'customers.isolate',
        ]);

        $this->actingAs($admin);

        $this->assertTrue(Gate::allows('customers.isolate'));
        $this->assertTrue($admin->hasPermission('customers.isolate'));

        $this->assertFalse(Gate::allows('system.destructive.action'));
        $this->assertFalse($admin->hasPermission('system.destructive.action'));
    }
}
