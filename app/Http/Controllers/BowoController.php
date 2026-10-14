<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BowoController extends Controller
{
    /**
     * Landing Page
     */
    public function home()
    {
        $total_users    = User::where('role', 'nasabah')->count();
        $total_waste    = (float)(Deposit::where('status', 'diverifikasi')->sum('weight') ?? 0);
        $total_deposits = Deposit::where('status', 'diverifikasi')->count();
        $waste_types    = WasteType::where('status', 'active')->orderBy('id', 'asc')->get();

        return view('home', compact('total_users', 'total_waste', 'total_deposits', 'waste_types'));
    }

    /**
     * Eco-Hero Leaderboard
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

    /**
     * Nasabah Dashboard
     */
    public function userDashboard(Request $request)
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
     * Form Setoran Sampah Nasabah
     */
    public function setorForm()
    {
        $waste_types = WasteType::where('status', 'active')->orderBy('name', 'asc')->get();

        return view('user.setor', compact('waste_types'));
    }

    /**
     * Proses Setor Sampah Nasabah
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
     * Riwayat Mutasi Saldo Nasabah
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

    /**
     * Dashboard Verifikasi Admin
     */
    public function adminDashboard()
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
     * Verifikasi / Tolak Setoran oleh Admin
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
     * Kelola Jenis & Harga Sampah oleh Admin
     */
    public function wastes()
    {
        $types = WasteType::orderBy('id', 'desc')->get();

        return view('admin.waste-types', compact('types'));
    }

    /**
     * Tambah / Edit Jenis Sampah
     */
    public function saveWaste(Request $request)
    {
        $data = $request->validate([
            'id'          => 'nullable|integer',
            'name'        => 'required|string|max:50',
            'category'    => 'required|string|max:50',
            'price_per_kg'=> 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000'
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
     * Hapus Jenis Sampah
     */
    public function deleteWaste(Request $request, $id)
    {
        $waste = WasteType::findOrFail($id);
        $waste->delete();

        return redirect()->route('admin.wastes')->with('success', 'Jenis sampah berhasil dihapus.');
    }

    /**
     * Laporan Rekapitulasi Sistem
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
