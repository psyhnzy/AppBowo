@extends('layouts.user', ['title' => 'Dashboard Nasabah — BOWO'])

@section('content')

    {{-- ===== HERO HEADER: Logo + BOWO + Sapaan ===== --}}
    <div class="relative bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-500 rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 overflow-hidden shadow-lg shadow-emerald-200">
        {{-- Dekorasi lingkaran background --}}
        <div class="absolute -top-6 -right-6 w-36 h-36 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-8 -left-4 w-48 h-48 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            {{-- Logo + Judul BOWO --}}
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white/20 backdrop-blur-sm p-2 sm:p-2.5 rounded-xl shadow-inner shrink-0">
                    <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-9 sm:h-11 w-auto">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl sm:text-3xl font-black text-white tracking-wide">BOWO</span>
                        <span class="hidden sm:inline-block bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">Nasabah</span>
                    </div>
                    <p class="text-emerald-100 text-xs sm:text-sm mt-0.5">Bank of Waste Online</p>
                </div>
            </div>
            {{-- Sapaan & Badge --}}
            <div class="text-left sm:text-right">
                <h2 class="text-lg sm:text-2xl font-black text-white">Halo, {{ $user->name }}! 👋</h2>
                <p class="text-emerald-100 text-xs sm:text-sm mt-0.5">Kelola setoran dan tabungan sampah Anda.</p>
                <span class="inline-block mt-2 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">✅ Nasabah Aktif</span>
            </div>
        </div>
    </div>

    {{-- ===== 4 Kartu Statistik ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-6 sm:mb-8">
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 group hover:shadow-md hover:border-emerald-100 transition-all">
            <div class="text-2xl mb-2">💰</div>
            <div class="text-slate-500 text-xs font-medium">Saldo Saat Ini</div>
            <div class="text-lg sm:text-2xl font-black text-emerald-600 mt-1 leading-tight">Rp {{ number_format($user->balance, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 group hover:shadow-md hover:border-amber-100 transition-all">
            <div class="text-2xl mb-2">⭐</div>
            <div class="text-slate-500 text-xs font-medium">Poin Kontribusi</div>
            <div class="text-lg sm:text-2xl font-black text-amber-500 mt-1 leading-tight">{{ number_format($user->points) }} <span class="text-sm font-semibold">Pts</span></div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 group hover:shadow-md hover:border-teal-100 transition-all">
            <div class="text-2xl mb-2">♻️</div>
            <div class="text-slate-500 text-xs font-medium">Sampah Didaur Ulang</div>
            <div class="text-lg sm:text-2xl font-black text-teal-600 mt-1 leading-tight">{{ number_format($total_weight, 1) }} <span class="text-sm font-semibold">kg</span></div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 group hover:shadow-md hover:border-slate-200 transition-all">
            <div class="text-2xl mb-2">📦</div>
            <div class="text-slate-500 text-xs font-medium">Total Pengajuan</div>
            <div class="text-lg sm:text-2xl font-black text-slate-800 mt-1 leading-tight">{{ $total_deposits }} <span class="text-sm font-semibold">Kali</span></div>
        </div>
    </div>

    {{-- ===== Target Setoran Bulan Ini ===== --}}
    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-4">
            <div class="flex items-center gap-2">
                <span class="text-lg">🎯</span>
                <h3 class="font-bold text-slate-800 text-sm sm:text-base">Target Setoran Bulan Ini</h3>
            </div>
            <span class="text-xs sm:text-sm text-slate-500 font-medium bg-slate-50 px-3 py-1 rounded-full">
                {{ number_format($total_weight, 1) }} kg / {{ number_format($target_weight, 1) }} kg
            </span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-700"
                 style="width: {{ $progress_pct }}%; background: linear-gradient(90deg, #059669, #10b981);">
            </div>
        </div>
        <div class="mt-2 flex justify-between items-center">
            <span class="text-xs text-slate-400">0 kg</span>
            <span class="text-xs font-black text-emerald-600">{{ $progress_pct }}% Tercapai</span>
            <span class="text-xs text-slate-400">{{ number_format($target_weight, 1) }} kg</span>
        </div>
    </div>

    {{-- ===== Tabel Riwayat Setoran Terbaru ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="text-lg">📋</span>
                <h3 class="font-bold text-base sm:text-lg text-slate-800">Setoran Terbaru</h3>
            </div>
            <a href="{{ route('user.setor') }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-xl transition shadow-sm">
                + Setor Sampah
            </a>
        </div>
        <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
            <table class="w-full text-left text-xs sm:text-sm min-w-[500px]">
                <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Jenis Sampah</th>
                        <th class="p-3">Berat</th>
                        <th class="p-3">Estimasi Nilai</th>
                        <th class="p-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recent_deposits as $dep)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="p-3 text-slate-500 whitespace-nowrap">
                                {{ is_string($dep->deposit_date) ? $dep->deposit_date : $dep->deposit_date?->format('d M Y') }}
                            </td>
                            <td class="p-3 font-medium text-slate-800 whitespace-nowrap">{{ $dep->wasteType->name ?? '-' }}</td>
                            <td class="p-3 whitespace-nowrap">{{ $dep->weight }} kg</td>
                            <td class="p-3 font-semibold text-slate-800 whitespace-nowrap">Rp {{ number_format($dep->total_value, 0, ',', '.') }}</td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($dep->status === 'diverifikasi')
                                    <span class="inline-block bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-bold">✅ Diverifikasi</span>
                                @elseif($dep->status === 'ditolak')
                                    <span class="inline-block bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-bold">❌ Ditolak</span>
                                @else
                                    <span class="inline-block bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full text-xs font-bold">⏳ Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">
                                <div class="text-4xl mb-2">📭</div>
                                Belum ada riwayat setoran.
                                <div class="mt-2">
                                    <a href="{{ route('user.setor') }}" class="text-emerald-600 font-bold hover:underline text-xs">Setor sekarang →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
