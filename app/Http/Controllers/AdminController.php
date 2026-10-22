<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard Verifikasi Admin
     */
    public function dashboard()
    {
        $pending = Deposit::with(['user', 'wasteType'])
            ->where('status', 'menunggu')
            ->orderBy('id', 'asc')
            ->get();

        $stats = [
            'pending' => $pending->count(),
            'users'   => User::where('role', 'nasabah')->count(),
            'weight'  => (float)(Deposit::where('status', 'diverifikasi')->sum('weight') ?? 0),
            'value'   => (float)(Deposit::where('status', 'diverifikasi')->sum('total_value') ?? 0),
        ];

        return view('admin.dashboard', compact('pending', 'stats'));
    }

    /**
     * Verifikasi atau Tolak Setoran Sampah
     */
    public function verify(Request $request, $deposit_id = null)
    {
        $id      = $deposit_id ?: $request->input('deposit_id');
        $deposit = Deposit::where('id', $id)->firstOrFail();

        if ($deposit->status !== 'menunggu') {
            return back()->with('error', 'Setoran sudah pernah diproses sebelumnya.');
        }

        $rawAction = strtolower($request->input('action', $request->input('status', '')));
        $action    = ($rawAction === 'verifikasi' || $rawAction === 'diverifikasi') ? 'diverifikasi' : 'ditolak';

        DB::transaction(function () use ($deposit, $action, $request) {
            $deposit->update([
                'status'      => $action,
                'verified_by' => $request->user()->id,
                'verified_at' => now()
            ]);

            if ($action === 'diverifikasi') {
                $deposit->user()->increment('balance', $deposit->total_value);
                $deposit->user()->increment('points', $deposit->points);

                Transaction::create([
                    'user_id'     => $deposit->user_id,
                    'deposit_id'  => $deposit->id,
                    'type'        => 'setoran_masuk',
                    'amount'      => $deposit->total_value,
                    'description' => 'Hasil setoran sampah ' . $deposit->weight . ' kg'
                ]);
            }
        });

        $msg = $action === 'diverifikasi'
            ? 'Setoran berhasil diverifikasi dan saldo nasabah bertambah.'
            : 'Setoran berhasil ditolak.';

        return back()->with('success', $msg);
    }

    /**
     * Kelola Master Data Jenis & Harga Sampah
     */
    public function wastes()
    {
        $types = WasteType::orderBy('id', 'desc')->get();

        return view('admin.waste-types', compact('types'));
    }

    /**
     * Simpan / Perbarui Data Jenis Sampah
     */
    public function saveWaste(Request $request)
    {
        $data = $request->validate([
            'id'           => 'nullable|integer',
            'name'         => 'required|string|max:50',
            'category'     => 'required|string|max:50',
            'price_per_kg' => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:1000'
        ]);

        $id = $request->input('id');

        if (!empty($id)) {
            $waste = WasteType::findOrFail($id);
            $waste->update([
                'name'         => $data['name'],
                'category'     => $data['category'],
                'price_per_kg' => $data['price_per_kg'],
                'description'  => $data['description'] ?? null
            ]);
            $msg = 'Jenis sampah berhasil diperbarui!';
        } else {
            WasteType::create([
                'name'         => $data['name'],
                'category'     => $data['category'],
                'price_per_kg' => $data['price_per_kg'],
                'description'  => $data['description'] ?? null,
                'status'       => 'active'
            ]);
            $msg = 'Jenis sampah baru berhasil ditambahkan!';
        }

        return back()->with('success', $msg);
    }

    /**
     * Hapus Data Jenis Sampah
     */
    public function deleteWaste(Request $request, $id)
    {
        $waste = WasteType::findOrFail($id);
        $waste->delete();

        return redirect()->route('admin.wastes')->with('success', 'Jenis sampah berhasil dihapus.');
    }

    /**
     * Rekapitulasi dan Laporan Sistem
     */
    public function reports()
    {
        $total_volume  = (float)(Deposit::where('status', 'diverifikasi')->sum('weight') ?? 0);
        $total_cashout = (float)(Deposit::where('status', 'diverifikasi')->sum('total_value') ?? 0);
        $total_points  = (int)(Deposit::where('status', 'diverifikasi')->sum('points') ?? 0);

        $reports = Deposit::with(['user', 'wasteType'])->latest('id')->get();

        $summary = [
            'users'  => User::where('role', 'nasabah')->count(),
            'count'  => Deposit::where('status', 'diverifikasi')->count(),
            'weight' => $total_volume,
            'value'  => $total_cashout
        ];

        return view('admin.reports', compact('total_volume', 'total_cashout', 'total_points', 'reports', 'summary'));
    }
}
