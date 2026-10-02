<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Tailwind pagination matching dark theme
        Paginator::useTailwind();

        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || request()->header('X-Forwarded-Proto') === 'https' || request()->isSecure()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Integrasi RBAC: Kaitkan Gate Laravel ke tabel RolePermission
        \Illuminate\Support\Facades\Gate::before(function ($user, string $ability) {
            if ($user?->role === 'super_admin') {
                return true;
            }

            try {
                if (\App\Models\RolePermission::where('role', $user?->role)->where('permission', $ability)->exists()) {
                    return true;
                }
            } catch (\Throwable) {
                // Table might not exist yet during migration tests
            }
        });
    }
}
