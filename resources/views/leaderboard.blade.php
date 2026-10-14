@extends('layouts.app', ['title' => 'Leaderboard Eco-Hero — BOWO', 'bodyClass' => 'bg-slate-50 min-h-screen text-slate-800'])

@section('body')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <div class="text-center mb-8 sm:mb-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-10 sm:h-12 w-auto">
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Leaderboard Eco-Hero</h1>
            <p class="text-slate-500 mt-1 text-xs sm:text-sm">Apresiasi khusus nasabah teraktif yang menjaga bumi bersama BOWO.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-4 sm:p-6 divide-y divide-slate-100">
                @forelse ($rankings as $index => $rank)
                    @php
                        $pos = $index + 1;
                        $badge = $pos === 1 ? '🥇' : ($pos === 2 ? '🥈' : ($pos === 3 ? '🥉' : '#' . $pos));
                        $bg = $pos === 1 ? 'bg-amber-50/70 border border-amber-200/60' : '';
                    @endphp
                    <div class="flex items-center justify-between py-3.5 sm:py-4 px-3 sm:px-4 rounded-xl {{ $bg }} transition hover:bg-slate-50/80">
                        <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 pr-2">
                            <span class="text-xl sm:text-2xl font-black w-8 sm:w-10 text-center text-slate-700 shrink-0">{{ $badge }}</span>
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-800 text-sm sm:text-base truncate">{{ $rank->name }}</h3>
                                <p class="text-xs text-slate-500">Telah mendaur ulang <b class="text-slate-700">{{ number_format((float)($rank->total_weight ?? 0), 1) }} kg</b></p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-emerald-600 font-extrabold text-base sm:text-xl">{{ number_format($rank->points) }}</span>
                            <span class="text-[10px] sm:text-xs text-slate-400 block font-semibold">Poin</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-sm">Belum ada nasabah terdaftar di leaderboard.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-emerald-600 font-bold hover:underline text-xs sm:text-sm">
                <span>←</span> Kembali ke Landing Page
            </a>
        </div>
    </div>
@endsection
