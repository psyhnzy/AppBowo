@extends('layouts.app', ['title' => 'Login — BOWO', 'bodyClass' => 'bg-emerald-50 min-h-screen flex items-center justify-center p-4 sm:p-6'])

@section('body')
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-emerald-100 my-auto">
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('assets/images/bowo.png') }}" alt="BOWO Logo" class="h-12 sm:h-14 w-auto mx-auto mb-2 object-contain">
                <h1 class="text-2xl sm:text-3xl font-black text-emerald-600">BOWO</h1>
            </a>
            <p class="text-slate-500 mt-0.5 text-xs sm:text-sm">Bank of Waste Online</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2.5 rounded-xl mb-4 text-xs sm:text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-2.5 rounded-xl mb-4 text-xs sm:text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" class="space-y-4 text-xs sm:text-sm">
            @csrf
            <div>
                <label class="block font-medium text-slate-700">Username / Email</label>
                <input type="text" name="identity" value="{{ old('identity', old('username')) }}" required autofocus placeholder="Masukkan username atau email" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            </div>
            <div>
                <label class="block font-medium text-slate-700">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="mt-1 w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 sm:py-3 rounded-xl transition duration-200 shadow-sm text-sm">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-xs sm:text-sm text-slate-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:underline">Daftar Sekarang</a>
        </p>
    </div>
@endsection
