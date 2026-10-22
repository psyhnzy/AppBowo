<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use App\Models\WasteType;

class HomeController extends Controller
{
    /**
     * Halaman Utama / Landing Page
     */
    public function index()
    {
        $total_users    = User::where('role', 'nasabah')->count();
        $total_waste    = (float)(Deposit::where('status', 'diverifikasi')->sum('weight') ?? 0);
        $total_deposits = Deposit::where('status', 'diverifikasi')->count();
        $waste_types    = WasteType::where('status', 'active')->orderBy('id', 'asc')->get();

        return view('home', compact('total_users', 'total_waste', 'total_deposits', 'waste_types'));
    }

    /**
     * Papan Peringkat / Eco-Hero Leaderboard
     */
    public function leaderboard()
    {
        $rankings = User::where('role', 'nasabah')
            ->withSum(['deposits as total_weight' => function ($q) {
                $q->where('status', 'diverifikasi');
            }], 'weight')
            ->orderByDesc('points')
            ->orderByDesc('balance')
            ->take(10)
            ->get();

        return view('leaderboard', compact('rankings'));
    }
}
