<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Group;
use Tests\DuskTestCase;

class OperationalWorkflowTest extends DuskTestCase
{
    #[Group('alpha')]
    #[Group('e2e')]
    #[Group('regression')]
    public function test_marketing_can_review_the_lead_pipeline(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->loginAs($this->loginAsRole('marketing'))
                ->visit('/marketing/leads')
                ->assertPathIs('/marketing/leads')
                ->assertSee('Prospek')
                ->assertPresent('a[href*="/marketing/leads/create"]');
        });
    }

    #[Group('uat')]
    #[Group('e2e')]
    public function test_technician_can_open_the_ticket_queue_and_workbench(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->loginAs($this->loginAsRole('technician'))
                ->visit('/technician/open-tickets')
                ->assertPathIs('/technician/open-tickets')
                ->visit('/technician/my-tasks')
                ->assertPathIs('/technician/my-tasks');
        });
    }

    #[Group('alpha')]
    #[Group('uat')]
    public function test_admin_can_review_core_operations(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->loginAs($this->loginAsRole('admin'))
                ->visit('/admin/customers')
                ->assertPathIs('/admin/customers')
                ->visit('/admin/packages')
                ->assertPathIs('/admin/packages')
                ->visit('/admin/billing')
                ->assertPathIs('/admin/billing')
                ->visit('/admin/tickets')
                ->assertPathIs('/admin/tickets')
                ->visit('/admin/reports')
                ->assertPathIs('/admin/reports');
        });
    }
}

