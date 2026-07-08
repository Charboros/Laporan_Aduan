<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Layanan Admas') }}</title>

    {{-- Font: Inter dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Sidebar nav link transition */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            color: #bfdbfe;
        }
        .nav-link:hover  { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-link.active { background: rgba(255,255,255,0.18); color: #fff; font-weight: 600; }
        .nav-link .nav-icon { opacity: 0.8; transition: opacity 0.15s; }
        .nav-link:hover .nav-icon,
        .nav-link.active .nav-icon { opacity: 1; }

        /* Alert toast */
        .alert-toast {
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased bg-slate-100 flex h-screen overflow-hidden">

    {{-- ======================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ======================================================= --}}
    <aside class="w-64 shrink-0 flex flex-col"
           style="background: linear-gradient(160deg, #1e3a8a 0%, #1d4ed8 60%, #2563eb 100%);">

        {{-- Logo / Brand --}}
        <div class="h-16 flex items-center px-6 border-b border-white/10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                        <path d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762z"/>
                        <path d="M9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-white font-bold text-sm">Layanan Admas</p>
                    <p class="text-blue-200 text-xs">Disdukcapil Kab. Tegal</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">
            <p class="text-blue-300/70 text-xs font-semibold uppercase tracking-wider px-2 mb-3">Menu</p>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('aduan.index') }}"
               class="nav-link {{ request()->routeIs('aduan.*') ? 'active' : '' }}">
                <svg class="nav-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Data Aduan
            </a>
        </nav>

        {{-- User Info + Logout --}}
        <div class="p-4 border-t border-white/10 shrink-0">
            @php $initials = strtoupper(substr(Auth::user()->name, 0, 1)); @endphp
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <span class="text-white font-bold text-sm">{{ $initials }}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-blue-200 text-xs truncate">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2
                               rounded-lg text-sm font-medium text-blue-100
                               bg-white/10 hover:bg-red-500/80 hover:text-white
                               transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ======================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ======================================================= --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Header --}}
        @isset($header)
            <header class="bg-white border-b border-slate-200 shrink-0">
                <div class="px-6 py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-6">

            {{-- Flash success --}}
            @if(session('success'))
                <div class="alert-toast mb-5 flex items-start gap-3 bg-emerald-50 border border-emerald-200
                            text-emerald-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Flash error --}}
            @if(session('error'))
                <div class="alert-toast mb-5 flex items-start gap-3 bg-red-50 border border-red-200
                            text-red-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

</body>
</html>
