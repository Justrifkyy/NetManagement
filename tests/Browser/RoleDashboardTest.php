<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Group;
use Tests\DuskTestCase;

class RoleDashboardTest extends DuskTestCase
{
    #[Group('smoke')]
    #[Group('uat')]
    #[Group('regression')]
    public function test_super_admin_reaches_dashboard(): void
    {
        $this->assertRolePages('super_admin', ['/superadmin/dashboard']);
    }

    #[Group('smoke')]
    #[Group('uat')]
    #[Group('regression')]
    public function test_admin_reaches_dashboard(): void
    {
        $this->assertRolePages('admin', ['/admin/dashboard']);
    }

    #[Group('smoke')]
    #[Group('uat')]
    #[Group('regression')]
    public function test_marketing_reaches_dashboard(): void
    {
        $this->assertRolePages('marketing', ['/marketing/dashboard']);
    }

    #[Group('smoke')]
    #[Group('uat')]
    #[Group('regression')]
    public function test_technician_reaches_dashboard(): void
    {
        $this->assertRolePages('technician', ['/technician/dashboard']);
    }

    #[Group('smoke')]
    #[Group('uat')]
    #[Group('regression')]
    public function test_customer_reaches_dashboard(): void
    {
        $this->assertRolePages('customer', ['/client/dashboard']);
    }

    #[Group('security')]
    #[Group('regression')]
    public function test_each_role_can_open_primary_pages(): void
    {
        $roles = [
            'super_admin' => ['/superadmin/users', '/superadmin/roles', '/superadmin/master', '/superadmin/settings', '/superadmin/audits', '/superadmin/maintenance'],
            'admin' => ['/admin/customers', '/admin/packages', '/admin/routers', '/admin/billing', '/admin/reports', '/admin/tickets', '/admin/leads'],
            'marketing' => ['/marketing/leads', '/marketing/reports'],
            'technician' => ['/technician/open-tickets', '/technician/my-tasks', '/technician/history', '/technician/profile'],
            'customer' => ['/client/billing', '/client/complaints', '/client/complaints/create'],
        ];

        $this->browse(function (Browser $browser) use ($roles): void {
            foreach ($roles as $role => $paths) {
                $this->loginAsSeededRole($browser, $role);
                foreach ($paths as $path) {
                    $browser->visit($path)->assertPathIs($path);
                }
            }
        });
    }

    private function assertRolePages(string $role, array $paths): void
    {
        $this->browse(function (Browser $browser) use ($role, $paths): void {
            $this->loginAsSeededRole($browser, $role);
            foreach ($paths as $path) {
                $browser->visit($path)->assertPathIs($path);
            }
        });
    }
}
