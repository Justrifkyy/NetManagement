<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- tsParticles CDN -->
        <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js"></script>

        <!-- Styles -->
        @livewireStyles
        
        <style>
            #particles {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
            }
        </style>
    </head>
    <body class="bg-black">
        <!-- Guest Navigation Bar -->
        <nav class="bg-gray-900/95 backdrop-blur-md border-b border-yellow-500/10 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center">
                            <img src="{{ asset('storage/img/LOGOMGD.png') }}" alt="NetManager Logo" class="h-8 w-auto object-contain">
                        </a>
                        <div class="hidden md:flex ms-10 space-x-8">
                            <a href="/" class="text-gray-300 hover:text-yellow-400 text-sm font-medium transition duration-200">Home</a>
                            <a href="#about" class="text-gray-300 hover:text-yellow-400 text-sm font-medium transition duration-200">About</a>
                            <a href="#services" class="text-gray-300 hover:text-yellow-400 text-sm font-medium transition duration-200">Services</a>
                            <a href="#contact" class="text-gray-300 hover:text-yellow-400 text-sm font-medium transition duration-200">Contact</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-300 hover:text-yellow-400 text-sm font-medium transition duration-200">Register</a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition duration-200">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div id="particles"></div>
        <div class="font-sans text-white antialiased relative z-10">
            {{ $slot }}
        </div>

        @livewireScripts
        
        <script>
            tsParticles.load("particles", {
                particles: {
                    number: {
                        value: 60,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: ["#fbbf24", "#f59e0b", "#d97706", "#ffffff"]
                    },
                    shape: {
                        type: "circle"
                    },
                    opacity: {
                        value: 0.5,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 2,
                            size_min: 0.5,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#fbbf24",
                        opacity: 0.3,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: "none",
                        random: false,
                        straight: false,
                        out_mode: "bounce",
                        bounce: true,
                        attract: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "grab"
                        },
                        onclick: {
                            enable: true,
                            mode: "push"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 200,
                            line_linked: {
                                opacity: 0.5
                            }
                        },
                        push: {
                            particles_nb: 4
                        }
                    }
                },
                retina_detect: true,
                background: {
                    color: "#000000"
                }
            });
        </script>
    </body>
</html>
