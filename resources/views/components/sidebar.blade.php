<div class="w-64 bg-slate-900 border-r border-slate-800 shadow-lg flex flex-col transition-all duration-300"
     :class="!sidebarOpen && 'hidden md:flex'"
     x-data="{ open: {} }">
    
    <!-- Logo Section -->
    <div class="p-6 border-b border-slate-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <x-application-mark class="w-8 h-8 text-amber-500 group-hover:text-amber-400 transition" />
            <div class="flex-1">
                <div class="text-sm font-bold text-white group-hover:text-amber-400 transition">Net Management</div>
                <div class="text-xs text-slate-400">Professional ISP</div>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="px-6 py-4 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">
                    @if (Auth::user()->role === 'super_admin')
                        <span class="text-purple-400">Super Admin</span>
                    @elseif (Auth::user()->role === 'admin')
                        <span class="text-red-400">Admin</span>
                    @elseif (Auth::user()->role === 'marketing')
                        <span class="text-amber-400">Marketing</span>
                    @elseif (Auth::user()->role === 'technician')
                        <span class="text-blue-400">Technician</span>
                    @else
                        <span class="text-green-400">Customer</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-2">
        
        <!-- Super Admin Menu -->
        @if (Auth::user()->role === 'super_admin')
            <div class="mb-6">
                <div class="px-4 py-2 text-xs font-bold text-purple-400 uppercase tracking-wider mb-3">Super Admin</div>
                
                <x-sidebar-link href="{{ route('superadmin.dashboard') }}" :active="request()->routeIs('superadmin.dashboard')" icon="chart-pie">
                    {{ __('Dashboard') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('superadmin.users.index') }}" :active="request()->routeIs('superadmin.users.*')" icon="users">
                    {{ __('Kelola Pegawai') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('superadmin.settings.index') }}" :active="request()->routeIs('superadmin.settings.*')" icon="cog">
                    {{ __('Pengaturan Sistem') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="monitor">
                    {{ __('Admin Dashboard') }}
                </x-sidebar-link>
            </div>
        @endif

        <!-- Admin Menu (Admin & Super Admin) -->
        @if (in_array(Auth::user()->role, ['admin', 'super_admin']))
            <div class="mb-6">
                <div class="px-4 py-2 text-xs font-bold text-red-400 uppercase tracking-wider mb-3">Operations</div>
                
                <x-sidebar-link href="{{ route('admin.customers.index') }}" :active="request()->routeIs('admin.customers.*')" icon="users">
                    {{ __('Pelanggan') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('admin.tickets.index') }}" :active="request()->routeIs('admin.tickets.*')" icon="ticket">
                    {{ __('Tiket Teknisi') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('admin.leads.index') }}" :active="request()->routeIs('admin.leads.*')" icon="target">
                    {{ __('Lead Marketing') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('admin.billing.index') }}" :active="request()->routeIs('admin.billing.*')" icon="wallet">
                    {{ __('Keuangan') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('admin.routers.index') }}" :active="request()->routeIs('admin.routers.*')" icon="server">
                    {{ __('Jaringan') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('admin.reports.index') }}" :active="request()->routeIs('admin.reports.*')" icon="document">
                    {{ __('Laporan') }}
                </x-sidebar-link>
            </div>
        @endif

        <!-- Marketing Menu -->
        @if (Auth::user()->role === 'marketing')
            <div class="mb-6">
                <div class="px-4 py-2 text-xs font-bold text-amber-400 uppercase tracking-wider mb-3">Marketing</div>
                
                <x-sidebar-link href="{{ route('marketing.dashboard') }}" :active="request()->routeIs('marketing.dashboard')" icon="chart-pie">
                    {{ __('Dashboard') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('marketing.leads.index') }}" :active="request()->routeIs('marketing.leads.*')" icon="target">
                    {{ __('Prospek') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('marketing.customers.index') }}" :active="request()->routeIs('marketing.customers.*')" icon="users">
                    {{ __('Pelanggan') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('marketing.schedules.index') }}" :active="request()->routeIs('marketing.schedules.*')" icon="calendar">
                    {{ __('Jadwal') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('marketing.reports.index') }}" :active="request()->routeIs('marketing.reports.*')" icon="document">
                    {{ __('Laporan') }}
                </x-sidebar-link>
            </div>
        @endif

        <!-- Technician Menu -->
        @if (Auth::user()->role === 'technician')
            <div class="mb-6">
                <div class="px-4 py-2 text-xs font-bold text-blue-400 uppercase tracking-wider mb-3">Technician</div>
                
                <x-sidebar-link href="{{ route('technician.dashboard') }}" :active="request()->routeIs('technician.dashboard')" icon="chart-pie">
                    {{ __('Dashboard') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('technician.survey.index') }}" :active="request()->routeIs('technician.survey.*')" icon="search">
                    {{ __('Survey') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('technician.installation.index') }}" :active="request()->routeIs('technician.installation.*')" icon="wrench">
                    {{ __('Instalasi') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('technician.ticket.index') }}" :active="request()->routeIs('technician.ticket.*')" icon="alert">
                    {{ __('Gangguan') }}
                </x-sidebar-link>
            </div>
        @endif

        <!-- Customer Menu -->
        @if (Auth::user()->role === 'customer')
            <div class="mb-6">
                <div class="px-4 py-2 text-xs font-bold text-green-400 uppercase tracking-wider mb-3">Customer</div>
                
                <x-sidebar-link href="{{ route('client.billing.index') }}" :active="request()->routeIs('client.billing.*')" icon="wallet">
                    {{ __('Pembayaran') }}
                </x-sidebar-link>
                
                <x-sidebar-link href="{{ route('client.complaints.index') }}" :active="request()->routeIs('client.complaints.*')" icon="alert">
                    {{ __('Pengajuan') }}
                </x-sidebar-link>
            </div>
        @endif

    </nav>

    <!-- Footer -->
    <div class="border-t border-slate-800 p-4">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" 
                class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-900/10 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>
