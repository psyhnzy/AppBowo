<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\WasteType;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    /**
     * Dashboard Utama Nasabah
     */
    public function dashboard(Request $request)
    {
        $user           = $request->user()->load('target');
        $total_weight   = (float)(Deposit::where('user_id', $user->id)->where('status', 'diverifikasi')->sum('weight') ?? 0);
        $total_deposits = Deposit::where('user_id', $user->id)->count();
        $target_weight  = ($user->target && (float)$user->target->target_weight > 0)
                            ? (float)$user->target->target_weight
                            : 10.0;
        $progress_pct   = $target_weight > 0 ? min(100, round(($total_weight / $target_weight) * 100)) : 0;

        $recent_deposits = Deposit::with('wasteType')
            ->where('user_id', $user->id)
            ->latest('id')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'user', 'total_weight', 'total_deposits',
            'target_weight', 'progress_pct', 'recent_deposits'
        ));
    }

    /**
     * Tampilkan Form Setor Sampah
     */
    public function setorForm()
    {
        $waste_types = WasteType::where('status', 'active')->orderBy('name', 'asc')->get();

        return view('user.setor', compact('waste_types'));
    }

    /**
     * Simpan Pengajuan Setor Sampah
     */
    public function setor(Request $request)
    {
        $data = $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'weight'        => 'required|numeric|min:0.01',
            'deposit_date'  => 'required|date',
            'notes'         => 'nullable|string|max:1000'
        ]);

        $waste       = WasteType::where('id', $data['waste_type_id'])->firstOrFail();
        $total_value = round($data['weight'] * $waste->price_per_kg, 2);
        $points      = (int)ceil($data['weight'] * 10);

        Deposit::create([
            'user_id'       => $request->user()->id,
            'waste_type_id' => $waste->id,
            'weight'        => $data['weight'],
            'price_per_kg'  => $waste->price_per_kg,
            'total_value'   => $total_value,
            'points'        => $points,
            'deposit_date'  => $data['deposit_date'],
            'notes'         => $data['notes'] ?? null,
            'status'        => 'menunggu'
        ]);

        return back()->with('success', 'Pengajuan setoran sampah berhasil dikirim!');
    }

    /**
     * Riwayat Mutasi Saldo & Transaksi Nasabah
     */
    public function riwayat(Request $request)
    {
        $user         = $request->user();
        $transactions = Transaction::with('deposit.wasteType')
            ->where('user_id', $user->id)
            ->latest('id')
            ->get();

        return view('user.riwayat', compact('user', 'transactions'));
    }
}
