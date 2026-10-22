<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Nasabah — BOWO' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Mobile Topbar Header (Hanya di layar kecil) -->
    <header class="md:hidden bg-emerald-900 text-white px-4 py-3.5 flex items-center justify-between sticky top-0 z-30 shadow-md">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-7 w-auto">
            <span class="text-xl font-black text-white">BOWO</span>
        </a>
        <button type="button" onclick="toggleSidebar()" class="p-2 rounded-lg bg-emerald-800 text-emerald-100 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-400" aria-label="Buka Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </header>

    <!-- Backdrop Overlay untuk Mobile -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Nasabah (Drawer di mobile, static di desktop) -->
    <aside id="user-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 md:w-64 bg-emerald-900 text-emerald-100 flex flex-col p-6 space-y-6 transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out shrink-0 min-h-screen shadow-xl md:shadow-none">
        <div class="flex items-center justify-between">
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-9 w-auto">
                <span class="text-2xl font-black text-white">BOWO</span>
            </a>
            <!-- Tombol Tutup Sidebar di Mobile -->
            <button type="button" onclick="toggleSidebar()" class="md:hidden p-1.5 text-emerald-300 hover:text-white rounded-lg focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition {{ request()->routeIs('user.dashboard') ? 'bg-emerald-800 text-white font-bold shadow-md shadow-emerald-950/40' : 'hover:bg-emerald-800/70 text-emerald-100' }}">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('user.setor') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition {{ request()->routeIs('user.setor*') ? 'bg-emerald-800 text-white font-bold shadow-md shadow-emerald-950/40' : 'hover:bg-emerald-800/70 text-emerald-100' }}">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Setor Sampah</span>
            </a>
            <a href="{{ route('user.riwayat') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition {{ request()->routeIs('user.riwayat*') ? 'bg-emerald-800 text-white font-bold shadow-md shadow-emerald-950/40' : 'hover:bg-emerald-800/70 text-emerald-100' }}">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span>Riwayat & Saldo</span>
            </a>
            <a href="{{ route('leaderboard') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition hover:bg-emerald-800/70 text-emerald-100">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                <span>Leaderboard</span>
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 py-2.5 px-4 text-red-300 hover:bg-red-900/50 rounded-xl transition">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>

        <div class="text-xs text-emerald-300/80 pt-4 border-t border-emerald-800">
            Nasabah: <b class="text-white block truncate">{{ auth()->user()->name ?? 'Nasabah' }}</b>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 lg:p-8 min-w-0 overflow-y-auto">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-xl text-sm mb-6 flex items-center justify-between shadow-sm">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm mb-6 flex items-center justify-between shadow-sm">
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm mb-6 shadow-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Script Drawer Toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('user-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isHidden = sidebar.classList.contains('-translate-x-full');
            
            if (isHidden) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
