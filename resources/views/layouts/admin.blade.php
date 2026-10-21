<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin — BOWO' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        @media print {
            aside, header, #sidebar-backdrop, .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; width: 100% !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Mobile Topbar Header (Hanya di layar kecil) -->
    <header class="md:hidden bg-slate-900 text-white px-4 py-3.5 flex items-center justify-between sticky top-0 z-30 shadow-md no-print">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-7 w-auto">
            <span class="text-xl font-black text-emerald-500">Admin</span>
        </a>
        <button type="button" onclick="toggleSidebar()" class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" aria-label="Buka Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </header>

    <!-- Backdrop Overlay untuk Mobile -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Admin (Drawer di mobile, static di desktop) -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 md:w-64 bg-slate-900 text-slate-200 flex flex-col p-6 space-y-6 no-print transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out shrink-0 min-h-screen shadow-xl md:shadow-none">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-9 w-auto">
                <span class="text-2xl font-black text-emerald-500">Admin</span>
            </a>
            <!-- Tombol Tutup Sidebar di Mobile -->
            <button type="button" onclick="toggleSidebar()" class="md:hidden p-1.5 text-slate-400 hover:text-white rounded-lg focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-bold shadow-md shadow-emerald-900/50' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Verifikasi Setoran</span>
            </a>
            <a href="{{ route('admin.wastes') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition {{ request()->routeIs('admin.wastes*') ? 'bg-emerald-600 text-white font-bold shadow-md shadow-emerald-900/50' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Jenis & Harga Sampah</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 py-2.5 px-4 rounded-xl transition {{ request()->routeIs('admin.reports') ? 'bg-emerald-600 text-white font-bold shadow-md shadow-emerald-900/50' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Laporan Sistem</span>
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 py-2.5 px-4 text-red-400 hover:bg-slate-800 rounded-xl transition">
                <svg class="w-5 h-5 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>

        <div class="text-xs text-slate-500 pt-4 border-t border-slate-800">
            Masuk sebagai: <b class="text-slate-300 block truncate">{{ auth()->user()->name ?? 'Administrator' }}</b>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:p-6 lg:p-8 min-w-0 overflow-y-auto">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="no-print bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-xl text-sm mb-6 flex items-center justify-between shadow-sm">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="no-print bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm mb-6 flex items-center justify-between shadow-sm">
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif
        @if($errors->any())
            <div class="no-print bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl text-sm mb-6 shadow-sm">
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
            const sidebar = document.getElementById('admin-sidebar');
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
