<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Group;
use Tests\DuskTestCase;

class ExploratoryAndResilienceTest extends DuskTestCase
{
    #[Group('exploratory')]
    #[Group('sanity')]
    public function test_authenticated_session_can_navigate_between_dashboard_and_profile(): void
    {
        $this->browse(function (Browser $browser): void {
            $this->loginAsSeededRole($browser, 'admin')
                ->visit('/admin/dashboard')
                ->assertPathIs('/admin/dashboard')
                ->visit('/admin/profile')
                ->assertPathIs('/admin/profile');
        });
    }

    #[Group('usability')]
    #[Group('compatibility')]
    public function test_customer_complaint_form_exposes_required_controls(): void
    {
        $this->browse(function (Browser $browser): void {
            $this->loginAsSeededRole($browser, 'customer')
                ->visit('/client/complaints/create')
            ->assertPresent('#title')
                ->assertPresent('select[name="priority"]')
                ->assertPresent('button[type="submit"]');
        });
    }
}
