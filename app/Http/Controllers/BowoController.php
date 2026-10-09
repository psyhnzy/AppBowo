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
    public function home(){
        $stats=['users'=>User::where('role','nasabah')->count(),'weight'=>Deposit::where('status','diverifikasi')->sum('weight'),'deposits'=>Deposit::where('status','diverifikasi')->count()];
        $wastes=WasteType::where('status','active')->get(); return view('home',compact('stats','wastes'));
    }
    public function leaderboard(){
        $users=User::where('role','nasabah')->orderByDesc('points')->orderByDesc('balance')->take(10)->get(); return view('leaderboard',compact('users'));
    }
    public function userDashboard(Request $request){
        $u=$request->user()->load('target');
        $weight=Deposit::where('user_id',$u->id)->where('status','diverifikasi')->sum('weight');
        $deposits=Deposit::where('user_id',$u->id)->count(); $recent=Deposit::with('wasteType')->where('user_id',$u->id)->latest('id')->take(5)->get();
        $target=$u->target?->target_weight ?? 10; $progress=$target>0?min(100,round(($weight/$target)*100)):0;
        return view('user.dashboard',compact('u','weight','deposits','recent','target','progress'));
    }
    public function setorForm(){ return view('user.setor',['wastes'=>WasteType::where('status','active')->get()]); }
    public function setor(Request $request){
        $data=$request->validate(['waste_type_id'=>'required|exists:waste_types,id','weight'=>'required|numeric|min:0.01','deposit_date'=>'required|date','notes'=>'nullable|max:1000']);
        $waste=WasteType::where('id',$data['waste_type_id'])->where('status','active')->firstOrFail(); $total=$data['weight']*$waste->price_per_kg; $points=(int)ceil($data['weight']*10);
        Deposit::create([...$data,'user_id'=>$request->user()->id,'price_per_kg'=>$waste->price_per_kg,'total_value'=>$total,'points'=>$points,'status'=>'menunggu']);
        return back()->with('success','Setoran berhasil dikirim dan menunggu verifikasi admin.');
    }
    public function riwayat(Request $request){ $transactions=Transaction::with('deposit.wasteType')->where('user_id',$request->user()->id)->latest('id')->get(); return view('user.riwayat',compact('transactions')); }
    public function adminDashboard(){ $pending=Deposit::with(['user','wasteType'])->where('status','menunggu')->latest('id')->get(); $stats=['pending'=>$pending->count(),'users'=>User::where('role','nasabah')->count(),'weight'=>Deposit::where('status','diverifikasi')->sum('weight'),'value'=>Deposit::where('status','diverifikasi')->sum('total_value')]; return view('admin.dashboard',compact('pending','stats')); }
    public function verify(Request $request, Deposit $deposit){
        if($deposit->status!=='menunggu') return back()->with('error','Setoran sudah diproses.');
        $status=$request->validate(['status'=>'required|in:diverifikasi,ditolak'])['status'];
        DB::transaction(function() use($deposit,$status,$request){
            $deposit->update(['status'=>$status,'verified_by'=>$request->user()->id,'verified_at'=>now()]);
            if($status==='diverifikasi'){
                $deposit->user()->increment('balance',$deposit->total_value); $deposit->user()->increment('points',$deposit->points);
                Transaction::create(['user_id'=>$deposit->user_id,'deposit_id'=>$deposit->id,'type'=>'setoran_masuk','amount'=>$deposit->total_value,'description'=>'Setoran sampah #'.$deposit->id.' terverifikasi']);
            }
        });
        return back()->with('success',$status==='diverifikasi'?'Setoran berhasil diverifikasi.':'Setoran ditolak.');
    }
    public function wastes(){ $wastes=WasteType::latest('id')->get(); return view('admin.waste-types',compact('wastes')); }
    public function saveWaste(Request $request){ $data=$request->validate(['name'=>'required|max:50','category'=>'required|max:50','price_per_kg'=>'required|numeric|min:0','description'=>'nullable','status'=>'required|in:active,inactive']); WasteType::create($data); return back()->with('success','Jenis sampah ditambahkan.'); }
    public function deleteWaste(WasteType $wasteType){ $wasteType->update(['status'=>'inactive']); return back()->with('success','Jenis sampah dinonaktifkan.'); }
    public function reports(){ $deposits=Deposit::with(['user','wasteType'])->latest('id')->get(); $summary=['users'=>User::where('role','nasabah')->count(),'weight'=>Deposit::where('status','diverifikasi')->sum('weight'),'value'=>Deposit::where('status','diverifikasi')->sum('total_value'),'count'=>Deposit::where('status','diverifikasi')->count()]; return view('admin.reports',compact('deposits','summary')); }
}
