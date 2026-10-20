<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — {{ config('mading.app_name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen bg-surface-muted">

    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- KIRI: Brand Panel --}}
        <div class="hidden lg:flex flex-col justify-between p-12 bg-brand-gradient text-white relative overflow-hidden">

            <div class="blob blob-brand w-96 h-96 -top-20 -left-20 animate-blob"></div>
            <div class="blob blob-brand w-80 h-80 bottom-10 right-10 animate-blob-delay-2"></div>

            <div class="relative z-10">
                <a href="{{ route('public.home') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                        <i data-lucide="megaphone" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xl font-bold">{{ config('mading.app_name') }}</span>
                </a>
            </div>

            <div class="relative z-10 max-w-md">
                <h1 class="text-4xl font-bold mb-4 leading-tight">
                    Satu ruang untuk semua informasi kampus Indonesia.
                </h1>
                <p class="text-white/80 leading-relaxed">
                    Temukan pengumuman, event, lomba, beasiswa, dan prestasi dari berbagai universitas di seluruh Indonesia.
                </p>
            </div>

            <div class="relative z-10 text-sm text-white/60">
                © {{ date('Y') }} {{ config('mading.app_name') }}
            </div>
        </div>

        {{-- KANAN: Form Panel --}}
        <div class="flex flex-col justify-center p-6 lg:p-12">
            <div class="w-full max-w-md mx-auto">

                <div class="lg:hidden mb-8 text-center">
                    <a href="{{ route('public.home') }}" class="inline-flex items-center gap-2 text-brand-700">
                        <i data-lucide="megaphone" class="w-7 h-7"></i>
                        <span class="text-lg font-bold">{{ config('mading.app_name') }}</span>
                    </a>
                </div>

                <div class="bg-white rounded-3xl shadow-card p-8">
                    @yield('content')
                </div>

            </div>
        </div>

    </div>

</body>
</html>