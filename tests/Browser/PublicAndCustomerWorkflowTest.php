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
    public function test_public_users_are_directed_to_login_instead_of_registration(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->assertSee('NetManager')
                ->visit('/login')
                ->assertPathIs('/login')
                ->assertDontSee('Create one')
                ->assertDontSee('Register');
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
                ->click('@create-complaint')
                ->assertPathIs('/client/complaints/create')
                ->assertPresent('form')
                ->assertPresent('#title')
                ->assertPresent('select[name="priority"]');
        });
    }

    #[Group('uat')]
    #[Group('e2e')]
    public function test_customer_can_submit_a_repair_report(): void
    {
        $title = 'Dusk repair report '.now()->format('His');

        $this->browse(function (Browser $browser) use ($title): void {
            $browser->loginAs($this->loginAsRole('customer'))
                ->visit('/client/complaints/create')
                ->click('input[name="category"][value="network_slow"]')
                ->type('#title', $title)
                ->select('#priority', 'high')
                ->type('#description', 'Koneksi internet terputus dan perlu pemeriksaan teknisi.')
                ->assertInputValue('#title', $title)
                ->assertInputValue('#description', 'Koneksi internet terputus dan perlu pemeriksaan teknisi.')
                ->press('button[type="submit"]')
                ->assertPathIs('/client/complaints')
                ->assertSee('Laporan kerusakan berhasil dikirim.')
                ->assertSee($title);
        });
    }
}
