<?php
namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm(){ return view('auth.login'); }
    public function login(Request $request){
        $data=$request->validate(['username'=>'required','password'=>'required']);
        if(Auth::attempt(['username'=>$data['username'],'password'=>$data['password'],'status'=>'active'])){
            $request->session()->regenerate();
            return redirect()->route(Auth::user()->role==='admin'?'admin.dashboard':'user.dashboard');
        }
        return back()->withInput()->with('error','Username/email atau password salah.');
    }
    public function registerForm(){ return view('auth.register'); }
    public function register(Request $request){
        $data=$request->validate([
            'name'=>'required|max:100','username'=>'required|max:50|unique:users,username','email'=>'required|email|max:100|unique:users,email',
            'phone'=>'required|max:20','address'=>'required','password'=>'required|min:6|confirmed'
        ]);
        $user=User::create([...$data,'password'=>Hash::make($data['password']),'role'=>'nasabah','status'=>'active','balance'=>0,'points'=>0]);
        Target::create(['user_id'=>$user->id,'target_weight'=>10,'period'=>'Bulan Ini']);
        Auth::login($user); $request->session()->regenerate();
        return redirect()->route('user.dashboard');
    }
    public function logout(Request $request){ Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('home'); }
}
