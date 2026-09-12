<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TechnicianLoginTest extends DuskTestCase
{
    /**
     * Skenario: Teknisi harus bisa login dan masuk ke dashboardnya.
     */
    public function test_teknisi_bisa_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/login')
                    ->type('#email', 'teknisi@netmanager.local')
                    ->type('#password', 'password')
                    ->press('button[type="submit"]')
                    ->assertPathIs('/technician/dashboard');
        });
    }
}