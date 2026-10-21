@extends('layouts.admin', ['title' => 'Dashboard Admin — BOWO'])

@section('content')

    {{-- ===== HERO HEADER: Logo + BOWO + Info Admin ===== --}}
    <div class="relative bg-gradient-to-br from-slate-800 via-slate-700 to-emerald-800 rounded-2xl sm:rounded-3xl p-5 sm:p-8 mb-6 sm:mb-8 overflow-hidden shadow-lg">
        {{-- Dekorasi lingkaran background --}}
        <div class="absolute -top-6 -right-6 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-8 -left-4 w-48 h-48 bg-emerald-600/10 rounded-full"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            {{-- Logo + Judul BOWO --}}
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="bg-white/10 backdrop-blur-sm p-2 sm:p-2.5 rounded-xl shadow-inner shrink-0">
                    <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-9 sm:h-11 w-auto">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl sm:text-3xl font-black text-white tracking-wide">BOWO</span>
                        <span class="inline-block bg-emerald-500/30 text-emerald-300 text-xs font-bold px-2 py-0.5 rounded-full">Admin</span>
                    </div>
                    <p class="text-slate-300 text-xs sm:text-sm mt-0.5">Bank of Waste Online — Panel Administrasi</p>
                </div>
            </div>
            {{-- Info Admin --}}
            <div class="text-left sm:text-right">
                <h2 class="text-lg sm:text-xl font-black text-white">Selamat Datang</h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-0.5">{{ auth()->user()->name ?? 'Administrator' }}</p>
                <span class="inline-block mt-2 bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full">
                    {{ count($pending) }} Setoran Menunggu
                </span>
            </div>
        </div>
    </div>

    {{-- ===== 4 Kartu Statistik ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-6 sm:mb-8">
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-100 transition-all">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="text-slate-500 text-xs font-medium">Total Nasabah</div>
            <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['users']) }}</div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-amber-100 transition-all">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-slate-500 text-xs font-medium">Menunggu Verifikasi</div>
            <div class="text-2xl sm:text-3xl font-black text-amber-500 mt-1">{{ number_format($stats['pending']) }}</div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-emerald-100 transition-all">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </div>
            <div class="text-slate-500 text-xs font-medium">Sampah Terverifikasi</div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">
                {{ number_format($stats['weight'], 1) }} <span class="text-base font-semibold">kg</span>
            </div>
        </div>
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-teal-100 transition-all">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="text-slate-500 text-xs font-medium">Total Nilai Disetor</div>
            <div class="text-lg sm:text-xl font-black text-emerald-600 mt-1 leading-tight">
                Rp {{ number_format($stats['value'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- ===== Tabel Setoran Menunggu ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <h3 class="font-bold text-base sm:text-lg text-slate-800">Setoran Menunggu Verifikasi</h3>
            </div>
            @if(count($pending) > 0)
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                    {{ count($pending) }} baru
                </span>
            @endif
        </div>

        <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
            <table class="w-full text-left text-xs sm:text-sm min-w-[650px]">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Nasabah</th>
                        <th class="p-3">Jenis Sampah</th>
                        <th class="p-3">Berat</th>
                        <th class="p-3">Total Nilai</th>
                        <th class="p-3">Poin</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pending as $p)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="p-3 text-slate-500 whitespace-nowrap">
                                {{ is_string($p->deposit_date) ? $p->deposit_date : $p->deposit_date?->format('d M Y') }}
                            </td>
                            <td class="p-3 whitespace-nowrap">
                                <div class="font-bold text-slate-800">{{ $p->user->name ?? 'Nasabah' }}</div>
                                <div class="text-xs text-slate-400">{{ $p->user->phone ?? '-' }}</div>
                            </td>
                            <td class="p-3 font-medium text-slate-800 whitespace-nowrap">{{ $p->wasteType->name ?? '-' }}</td>
                            <td class="p-3 font-semibold whitespace-nowrap">{{ $p->weight }} kg</td>
                            <td class="p-3 font-bold text-emerald-600 whitespace-nowrap">Rp {{ number_format($p->total_value, 0, ',', '.') }}</td>
                            <td class="p-3 font-bold text-amber-500 whitespace-nowrap">{{ $p->points }} Pts</td>
                            <td class="p-3 whitespace-nowrap">
                                <form action="{{ route('admin.verify', $p->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    <input type="hidden" name="deposit_id" value="{{ $p->id }}">
                                    <button type="submit" name="action" value="verifikasi"
                                        onclick="return confirm('Verifikasi setoran ini?')"
                                        class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Setujui
                                    </button>
                                    <button type="submit" name="action" value="ditolak"
                                        onclick="return confirm('Tolak setoran ini?')"
                                        class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-400">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="font-semibold text-slate-500">Semua setoran telah diverifikasi!</p>
                                <p class="text-xs mt-1">Tidak ada pengajuan yang menunggu.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
