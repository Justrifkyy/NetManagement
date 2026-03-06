<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto text-sky-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'super_admin')
                        <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                            {{ __('Kelola Akun') }}
                        </x-nav-link>
                    @endif

                    @if (in_array(Auth::user()->role, ['admin', 'super_admin']))
                        <x-nav-link href="{{ route('admin.tickets.index') }}" :active="request()->routeIs('admin.tickets.*')">
                            {{ __('QC & Aktivasi') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('admin.billing.index') }}" :active="request()->routeIs('admin.billing.*')">
                            {{ __('Keuangan') }}
                        </x-nav-link>
                    @endif

                    @if (in_array(Auth::user()->role, ['marketing', 'admin', 'super_admin']))
                        <x-nav-link href="{{ route('marketing.leads.index') }}" :active="request()->routeIs('marketing.leads.*')">
                            {{ __('Data Prospek') }}
                        </x-nav-link>
                    @endif

                    @if (in_array(Auth::user()->role, ['technician', 'admin', 'super_admin']))
                        <x-nav-link href="{{ route('technician.tickets.index') }}" :active="request()->routeIs('technician.tickets.*')">
                            {{ __('Bursa Tugas') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'technician')
                        <x-nav-link href="{{ route('technician.process.index') }}" :active="request()->routeIs('technician.process.*')">
                            {{ __('Tugas Saya') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'customer')
                        <x-nav-link href="{{ route('client.invoices.index') }}" :active="request()->routeIs('client.invoices.*')">
                            {{ __('Tagihan Saya') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-60">
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Team') }}</div>
                                    <x-dropdown-link
                                        href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">{{ __('Team Settings') }}</x-dropdown-link>
                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link
                                            href="{{ route('teams.create') }}">{{ __('Create New Team') }}</x-dropdown-link>
                                    @endcan
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>
                                        <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Switch Teams') }}
                                        </div>
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        <span
                                            class="mr-2 px-2 py-0.5 rounded text-xs font-bold text-white uppercase 
                                            {{ Auth::user()->role == 'super_admin' ? 'bg-purple-600' : '' }}
                                            {{ Auth::user()->role == 'admin' ? 'bg-red-500' : '' }}
                                            {{ Auth::user()->role == 'marketing' ? 'bg-blue-500' : '' }}
                                            {{ Auth::user()->role == 'technician' ? 'bg-yellow-500' : '' }}
                                            {{ Auth::user()->role == 'customer' ? 'bg-green-500' : '' }}
                                        ">
                                            {{ str_replace('_', ' ', Auth::user()->role) }}
                                        </span>
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile Setting') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                    class="text-red-600 font-semibold">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-gray-50 border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'super_admin')
                <x-responsive-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                    {{ __('Kelola Akun') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(Auth::user()->role, ['admin', 'super_admin']))
                <x-responsive-nav-link href="{{ route('admin.tickets.index') }}" :active="request()->routeIs('admin.tickets.*')">
                    {{ __('QC & Aktivasi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin.billing.index') }}" :active="request()->routeIs('admin.billing.*')">
                    {{ __('Keuangan') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(Auth::user()->role, ['marketing', 'admin', 'super_admin']))
                <x-responsive-nav-link href="{{ route('marketing.leads.index') }}" :active="request()->routeIs('marketing.leads.*')">
                    {{ __('Data Prospek') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(Auth::user()->role, ['technician', 'admin', 'super_admin']))
                <x-responsive-nav-link href="{{ route('technician.tickets.index') }}" :active="request()->routeIs('technician.tickets.*')">
                    {{ __('Bursa Tugas') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'technician')
                <x-responsive-nav-link href="{{ route('technician.process.index') }}" :active="request()->routeIs('technician.process.*')">
                    {{ __('Tugas Saya') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'customer')
                <x-responsive-nav-link href="{{ route('client.invoices.index') }}" :active="request()->routeIs('client.invoices.*')">
                    {{ __('Tagihan Saya') }}
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-white">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover border border-gray-200"
                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    <span
                        class="inline-block mt-1 px-2 py-0.5 text-xs font-bold text-gray-600 bg-gray-200 rounded uppercase tracking-widest">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                        class="text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
