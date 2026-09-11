<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Group;
use Tests\DuskTestCase;

class PublicAndCustomerWorkflowTest extends DuskTestCase
{
    #[Group('smoke')]
    #[Group('beta')]
    #[Group('compatibility')]
    public function test_public_registration_entry_points_are_available(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->assertSee('NetManager')
                ->visit('/daftar-internet')
                ->assertPathIs('/daftar-internet')
                ->assertPresent('form')
                ->assertPresent('input')
                ->assertPresent('button');
        });
    }

    #[Group('uat')]
    #[Group('e2e')]
    #[Group('usability')]
    public function test_customer_can_review_billing_and_start_a_complaint(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->loginAs($this->loginAsRole('customer'))
                ->visit('/client/billing')
                ->assertPathIs('/client/billing')
                ->assertSee('Tagihan')
                ->visit('/client/complaints')
                ->assertPathIs('/client/complaints')
                ->assertSee('Pengajuan')
                ->clickLink('Buat Pengajuan Baru')
                ->assertPathIs('/client/complaints/create')
                ->assertPresent('form')
                ->assertPresent('input[name="title"]')
                ->assertPresent('select[name="priority"]');
        });
    }
}

