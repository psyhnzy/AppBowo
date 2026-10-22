@extends('layouts.user', ['title' => 'Riwayat & Mutasi Saldo — BOWO'])

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Riwayat Mutasi Saldo</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Catatan pemasukan saldo dari hasil penimbangan sampah Anda.</p>
        </div>
    </div>

    {{-- Kartu Saldo & Poin --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <div class="text-slate-500 text-xs font-medium">Saldo Saat Ini</div>
                <div class="text-xl sm:text-2xl font-black text-emerald-600 mt-0.5">
                    Rp {{ number_format($user->balance, 0, ',', '.') }}
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <div>
                <div class="text-slate-500 text-xs font-medium">Total Poin Kontribusi</div>
                <div class="text-xl sm:text-2xl font-black text-amber-500 mt-0.5">
                    {{ number_format($user->points) }} Pts
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Mutasi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <h3 class="font-bold text-base sm:text-lg text-slate-800 mb-4">Riwayat Transaksi</h3>
        <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
            <table class="w-full text-left text-xs sm:text-sm min-w-[500px]">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                    <tr>
                        <th class="p-3">Tanggal Transaksi</th>
                        <th class="p-3">Keterangan</th>
                        <th class="p-3 text-center">Tipe</th>
                        <th class="p-3 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $tx)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-3 text-slate-500 whitespace-nowrap">
                                {{ $tx->created_at ? \Carbon\Carbon::parse($tx->created_at)->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="p-3 font-medium text-slate-800">{{ $tx->description }}</td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($tx->type === 'setoran_masuk')
                                    <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold">Kredit (Masuk)</span>
                                @else
                                    <span class="inline-block bg-slate-100 text-slate-800 text-xs px-2.5 py-1 rounded-full font-bold">{{ ucfirst($tx->type) }}</span>
                                @endif
                            </td>
                            <td class="p-3 font-black text-emerald-600 text-right whitespace-nowrap">+Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">
                                <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                Belum ada catatan mutasi saldo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
