@extends('layouts.app', ['title' => 'BOWO — Bank of Waste Online'])

@section('body')

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-emerald-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex justify-between items-center">

            {{-- Logo + BOWO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-8 sm:h-9 w-auto transition group-hover:scale-105">
                <span class="text-xl sm:text-2xl font-black text-emerald-600 tracking-wide">BOWO</span>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex space-x-6 text-slate-600 font-medium text-sm">
                <a href="#beranda"      class="hover:text-emerald-600 transition relative after:absolute after:-bottom-0.5 after:left-0 after:w-0 hover:after:w-full after:h-0.5 after:bg-emerald-500 after:transition-all">Beranda</a>
                <a href="#tentang"      class="hover:text-emerald-600 transition relative after:absolute after:-bottom-0.5 after:left-0 after:w-0 hover:after:w-full after:h-0.5 after:bg-emerald-500 after:transition-all">Tentang</a>
                <a href="#cara-kerja"   class="hover:text-emerald-600 transition relative after:absolute after:-bottom-0.5 after:left-0 after:w-0 hover:after:w-full after:h-0.5 after:bg-emerald-500 after:transition-all">Cara Kerja</a>
                <a href="#jenis-sampah" class="hover:text-emerald-600 transition relative after:absolute after:-bottom-0.5 after:left-0 after:w-0 hover:after:w-full after:h-0.5 after:bg-emerald-500 after:transition-all">Jenis Sampah</a>
                <a href="{{ route('leaderboard') }}" class="hover:text-emerald-600 transition relative after:absolute after:-bottom-0.5 after:left-0 after:w-0 hover:after:w-full after:h-0.5 after:bg-emerald-500 after:transition-all">Leaderboard</a>
            </div>

            {{-- Tombol Aksi Desktop --}}
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                       class="px-5 py-2 bg-emerald-600 text-white rounded-xl font-semibold text-sm hover:bg-emerald-700 shadow-sm shadow-emerald-200 transition">
                        Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-emerald-600 border border-emerald-300 rounded-xl hover:bg-emerald-50 font-semibold transition text-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-semibold transition text-sm shadow-sm shadow-emerald-200">
                        Daftar Gratis
                    </a>
                @endauth
            </div>

            {{-- Hamburger Mobile --}}
            <button type="button" onclick="toggleNavMenu()"
                    class="md:hidden p-2 rounded-lg text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 transition focus:outline-none focus:ring-2 focus:ring-emerald-400"
                    aria-label="Buka Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Menu Dropdown Mobile --}}
        <div id="mobile-nav-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-4 space-y-1">
            <a href="#beranda"      onclick="toggleNavMenu()" class="block px-3 py-2.5 rounded-xl text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition">Beranda</a>
            <a href="#tentang"      onclick="toggleNavMenu()" class="block px-3 py-2.5 rounded-xl text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition">Tentang</a>
            <a href="#cara-kerja"   onclick="toggleNavMenu()" class="block px-3 py-2.5 rounded-xl text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition">Cara Kerja</a>
            <a href="#jenis-sampah" onclick="toggleNavMenu()" class="block px-3 py-2.5 rounded-xl text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition">Jenis Sampah</a>
            <a href="{{ route('leaderboard') }}" class="block px-3 py-2.5 rounded-xl text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition">🏆 Leaderboard</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                       class="text-center w-full py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"    class="text-center w-full py-2.5 text-emerald-600 border border-emerald-300 rounded-xl font-bold text-sm hover:bg-emerald-50 transition">Login</a>
                    <a href="{{ route('register') }}" class="text-center w-full py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition">Daftar Akun Baru</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ===== HERO SECTION ===== --}}
    <section id="beranda" class="relative py-16 sm:py-24 overflow-hidden bg-gradient-to-br from-emerald-50 via-teal-50/60 to-white">
        {{-- Dekorasi background --}}
        <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-100/50 rounded-full -translate-y-1/3 translate-x-1/3 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-100/40 rounded-full translate-y-1/3 -translate-x-1/3 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
            {{-- Teks Hero --}}
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-700 font-semibold rounded-full text-xs mb-5 shadow-sm">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    Eco-Tech Ecosystem
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 leading-tight">
                    Ubah Sampah Jadi<br>
                    <span class="text-emerald-600">Tabungan Berharga.</span>
                </h1>
                <p class="text-slate-600 mt-5 text-sm sm:text-base md:text-lg leading-relaxed">
                    Kelola sampah dari rumah dengan mudah, dapatkan saldo tabungan, serta poin kontribusi untuk kelestarian lingkungan bersama <strong class="text-emerald-600">BOWO</strong>.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : route('register') }}"
                       class="text-center px-7 py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition hover:-translate-y-0.5 transform">
                        Mulai Sekarang 🚀
                    </a>
                    <a href="#tentang"
                       class="text-center px-7 py-3.5 bg-white text-slate-700 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition">
                        Pelajari BOWO
                    </a>
                </div>
            </div>

            {{-- Kartu Statistik Hero --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-md border border-emerald-100 text-center hover:shadow-lg transition hover:-translate-y-1 transform">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600">{{ number_format($total_users) }}+</div>
                    <div class="text-xs sm:text-sm text-slate-500 font-medium mt-2">👥 Nasabah Aktif</div>
                </div>
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-md border border-emerald-100 text-center hover:shadow-lg transition hover:-translate-y-1 transform">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600">{{ number_format($total_waste, 1) }}</div>
                    <div class="text-xs sm:text-sm text-slate-500 font-medium mt-2">♻️ kg Terdaur Ulang</div>
                </div>
                <div class="col-span-2 bg-gradient-to-br from-emerald-600 to-teal-500 p-5 rounded-2xl shadow-md text-center text-white hover:shadow-lg transition hover:-translate-y-1 transform">
                    <div class="text-2xl font-black">{{ number_format($total_deposits) }}+</div>
                    <div class="text-xs font-medium mt-1 text-emerald-100">📦 Total Setoran Terverifikasi</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== SECTION TENTANG ===== --}}
    <section id="tentang" class="py-14 sm:py-20 bg-white border-t border-slate-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full mb-3">Tentang Kami</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Apa itu <span class="text-emerald-600">BOWO</span>?</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-2">Bank of Waste Online — Solusi Cerdas Pengelolaan Sampah</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100 text-center hover:shadow-md transition">
                    <div class="text-4xl mb-3">🌿</div>
                    <h3 class="font-bold text-slate-800 mb-2">Ramah Lingkungan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Membantu masyarakat mengelola sampah anorganik secara terstruktur dan transparan.</p>
                </div>
                <div class="bg-teal-50 p-6 rounded-2xl border border-teal-100 text-center hover:shadow-md transition">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="font-bold text-slate-800 mb-2">Bernilai Ekonomi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Setiap gram sampah dikonversi menjadi saldo rupiah yang bisa dicairkan kapan saja.</p>
                </div>
                <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100 text-center hover:shadow-md transition">
                    <div class="text-4xl mb-3">⭐</div>
                    <h3 class="font-bold text-slate-800 mb-2">Poin Penghargaan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Kumpulkan poin dari setiap setoran dan bersaing di Leaderboard Eco-Hero BOWO.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== SECTION CARA KERJA ===== --}}
    <section id="cara-kerja" class="py-14 sm:py-20 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10 sm:mb-14">
                <span class="inline-block bg-slate-200 text-slate-600 text-xs font-bold px-3 py-1 rounded-full mb-3">Cara Kerja</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">4 Langkah Mudah Bersama BOWO</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-2">Dari rumah ke saldo — semua bisa dilakukan dengan mudah</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                @php
                    $steps = [
                        ['no' => '01', 'icon' => '🗂️', 'title' => 'Pilah Sampah',             'desc' => 'Pilah sampah anorganik (botol plastik, kardus, kertas, logam) di rumah dalam keadaan bersih.'],
                        ['no' => '02', 'icon' => '📝', 'title' => 'Isi Form Setor',            'desc' => 'Masuk ke akun nasabah dan isi form pengajuan setoran sampah sesuai estimasi berat.'],
                        ['no' => '03', 'icon' => '⚖️', 'title' => 'Penimbangan & Verifikasi', 'desc' => 'Bawa sampah ke lokasi Bank Sampah BOWO untuk ditimbang dan diverifikasi oleh Admin.'],
                        ['no' => '04', 'icon' => '💳', 'title' => 'Cairkan Saldo & Poin',     'desc' => 'Setelah disetujui, saldo rupiah dan poin kontribusi langsung bertambah di akun kamu.'],
                    ];
                @endphp
                @foreach($steps as $step)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md hover:border-emerald-200 transition group">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-9 h-9 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-extrabold text-sm shadow-sm shadow-emerald-300 group-hover:bg-emerald-700 transition">
                            {{ $step['no'] }}
                        </span>
                        <span class="text-2xl">{{ $step['icon'] }}</span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-2">{{ $step['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== SECTION JENIS SAMPAH ===== --}}
    <section id="jenis-sampah" class="py-14 sm:py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10 sm:mb-14">
                <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full mb-3">Daftar Sampah</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Jenis & Harga Sampah</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-2">Harga per kg yang berlaku saat ini di Bank Sampah BOWO</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($waste_types as $type)
                    <div class="border rounded-2xl p-5 sm:p-6 bg-slate-50 border-slate-200 flex flex-col justify-between hover:shadow-md hover:border-emerald-200 hover:bg-white transition group">
                        <div>
                            <span class="text-xs font-bold uppercase text-emerald-600 bg-emerald-100 px-2.5 py-1 rounded-full">{{ $type->category }}</span>
                            <h3 class="font-bold text-lg mt-3 text-slate-800 group-hover:text-emerald-700 transition">{{ $type->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $type->description ?? 'Sampah anorganik terpilah.' }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center">
                            <span class="text-slate-400 text-xs font-medium">Harga/Kg</span>
                            <span class="text-emerald-600 font-black text-base sm:text-lg">Rp {{ number_format($type->price_per_kg, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CTA bawah jenis sampah --}}
            <div class="text-center mt-10">
                <a href="{{ auth()->check() ? route('user.setor') : route('register') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition hover:-translate-y-0.5 transform text-sm">
                    Mulai Setor Sampah Sekarang 🚀
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-slate-900 text-slate-400 py-8 sm:py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-7 w-auto opacity-80">
                <span class="text-white font-black text-lg">BOWO</span>
            </div>
            <p class="text-xs sm:text-sm text-center">© 2026 BOWO (Bank of Waste Online). All rights reserved.</p>
            <div class="flex items-center gap-4 text-xs">
                <a href="#beranda" class="hover:text-emerald-400 transition">Beranda</a>
                <a href="#tentang" class="hover:text-emerald-400 transition">Tentang</a>
                <a href="{{ route('leaderboard') }}" class="hover:text-emerald-400 transition">Leaderboard</a>
            </div>
        </div>
    </footer>

    <script>
        function toggleNavMenu() {
            const menu = document.getElementById('mobile-nav-menu');
            menu.classList.toggle('hidden');
        }
    </script>
@endsection
