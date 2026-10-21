@extends('layouts.admin', ['title' => 'Laporan Rekapitulasi — BOWO'])

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3 sm:gap-4">
            <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-10 sm:h-12 w-auto">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Laporan Rekapitulasi Sistem</h2>
                <p class="text-xs sm:text-sm text-slate-500">Bank of Waste Online (BOWO)</p>
            </div>
        </div>
        <button onclick="window.print()" class="no-print w-full sm:w-auto bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-emerald-700 shadow-md transition flex items-center justify-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <!-- 3 Kartu Ringkasan (1 col di HP, 3 col di Desktop) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-slate-500 text-xs font-medium">Total Volume Sampah</div>
            <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($total_volume, 1) }} kg</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-slate-500 text-xs font-medium">Total Nilai Transaksi</div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">Rp {{ number_format($total_cashout, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="text-slate-500 text-xs font-medium">Total Poin Disalurkan</div>
            <div class="text-2xl sm:text-3xl font-black text-amber-500 mt-1">{{ number_format($total_points) }} Pts</div>
        </div>
    </div>

    <!-- Tabel Rekapitulasi -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-6">
        <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
            <table class="w-full text-left text-xs sm:text-sm min-w-[600px]">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Nasabah</th>
                        <th class="p-3">Jenis Sampah</th>
                        <th class="p-3">Berat</th>
                        <th class="p-3">Total Nilai</th>
                        <th class="p-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($reports as $r)
                        <tr>
                            <td class="p-3 text-slate-500 whitespace-nowrap">
                                {{ is_string($r->deposit_date) ? $r->deposit_date : $r->deposit_date?->format('d M Y') }}
                            </td>
                            <td class="p-3 font-semibold text-slate-800 whitespace-nowrap">{{ $r->user->name ?? 'Nasabah' }}</td>
                            <td class="p-3 text-slate-700 whitespace-nowrap">{{ $r->wasteType->name ?? '-' }}</td>
                            <td class="p-3 whitespace-nowrap">{{ $r->weight }} kg</td>
                            <td class="p-3 font-bold text-emerald-600 whitespace-nowrap">Rp {{ number_format($r->total_value, 0, ',', '.') }}</td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($r->status === 'diverifikasi')
                                    <span class="text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full text-xs font-bold">Diverifikasi</span>
                                @elseif($r->status === 'ditolak')
                                    <span class="text-red-700 bg-red-100 px-2.5 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                @else
                                    <span class="text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full text-xs font-bold">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">Belum ada data setoran sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
