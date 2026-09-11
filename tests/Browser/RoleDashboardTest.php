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
    public function test_every_seeded_role_reaches_its_dashboard(): void
    {
        $dashboards = [
            'super_admin' => '/superadmin/dashboard',
            'admin' => '/admin/dashboard',
            'marketing' => '/marketing/dashboard',
            'technician' => '/technician/dashboard',
            'customer' => '/client/dashboard',
        ];

        foreach ($dashboards as $role => $dashboard) {
            $this->browse(function (Browser $browser) use ($role, $dashboard): void {
                $this->loginThroughForm($browser, $role)
                    ->visit('/dashboard')
                    ->assertPathIs($dashboard);
            });
        }
    }

    #[Group('security')]
    #[Group('regression')]
    public function test_each_role_can_open_its_primary_application_pages(): void
    {
        $pages = [
            'super_admin' => [
                '/superadmin/users',
                '/superadmin/roles',
                '/superadmin/master',
                '/superadmin/settings',
                '/superadmin/audits',
                '/superadmin/maintenance',
            ],
            'admin' => [
                '/admin/customers',
                '/admin/packages',
                '/admin/routers',
                '/admin/billing',
                '/admin/reports',
                '/admin/tickets',
                '/admin/leads',
            ],
            'marketing' => [
                '/marketing/leads',
                '/marketing/reports',
            ],
            'technician' => [
                '/technician/open-tickets',
                '/technician/my-tasks',
                '/technician/history',
                '/technician/profile',
            ],
            'customer' => [
                '/client/billing',
                '/client/complaints',
                '/client/complaints/create',
            ],
        ];

        foreach ($pages as $role => $paths) {
            $this->browse(function (Browser $browser) use ($role, $paths): void {
                $browser->loginAs($this->loginAsRole($role));

                foreach ($paths as $path) {
                    $browser->visit($path)->assertPathIs($path);
                }
            });
        }
    }
}
