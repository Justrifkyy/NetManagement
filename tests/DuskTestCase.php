<?php

namespace Tests;

use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\BeforeClass;
use RuntimeException;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Credentials created by DatabaseSeeder for browser test sessions.
     *
     * @var array<string, string>
     */
    protected const ROLE_EMAILS = [
        'super_admin' => 'owner@netmanager.local',
        'admin' => 'admin@netmanager.local',
        'marketing' => 'marketing@netmanager.local',
        'technician' => 'teknisi@netmanager.local',
        'customer' => 'budi@netmanager.local',
    ];

    protected function loginAsRole(string $role): User
    {
        $email = self::ROLE_EMAILS[$role] ?? throw new RuntimeException(
            "No seeded Dusk account is configured for role [{$role}]."
        );

        $user = User::where('email', $email)->first();

        if (! $user) {
            throw new RuntimeException(
                "Seeded Dusk account [{$email}] was not found. Run `php artisan db:seed` before Dusk."
            );
        }

        return $user;
    }

    protected function loginThroughForm(Browser $browser, string $role): Browser
    {
        $user = $this->loginAsRole($role);

        return $browser->logout()
            ->visit('/login')
            ->type('#email', $user->email)
            ->type('#password', 'password')
            ->press('button[type="submit"]');
    }

    protected function loginAsSeededRole(Browser $browser, string $role): Browser
    {
        $user = $this->loginAsRole($role);

        return $browser->visit('/_dusk/logout')
            ->visit('/_dusk/login/'.$user->getKey());
    }

    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
}
