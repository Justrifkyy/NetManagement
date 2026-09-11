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
            $browser->visit('/login')
                    // Memasukkan email teknisi
                    ->type('email', 'teknisi@netmanager.local')
                    // Memasukkan password
                    ->type('password', 'password')
                    // Mengeklik tombol submit form login
                    ->press('button[type="submit"]')
                    // Memastikan berhasil masuk ke halaman dashboard teknisi
                    ->assertPathIs('/technician/dashboard');
        });
    }
}