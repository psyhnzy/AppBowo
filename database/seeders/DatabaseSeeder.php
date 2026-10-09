<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; use App\Models\User; use App\Models\WasteType; use App\Models\Target; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run(){
 $admin=User::create(['name'=>'Administrator BOWO','username'=>'admin','email'=>'admin@bowo.id','phone'=>'081234567890','address'=>'Kantor Pusat BOWO','password'=>Hash::make('admin123'),'role'=>'admin','status'=>'active']);
 foreach([['Budi Santoso','budi','budi@gmail.com','081298765432','Jl. Merdeka No. 12',25000,50,10],['Siti Rahma','siti','siti@gmail.com','085612345678','Jl. Mawar No. 5',40000,80,15]] as $x){$u=User::create(['name'=>$x[0],'username'=>$x[1],'email'=>$x[2],'phone'=>$x[3],'address'=>$x[4],'password'=>Hash::make('password123'),'role'=>'nasabah','balance'=>$x[5],'points'=>$x[6],'status'=>'active']);Target::create(['user_id'=>$u->id,'target_weight'=>$x[7],'period'=>'Bulan Ini']);}
 WasteType::insert([
 ['name'=>'Plastik PET (Botol Bening)','category'=>'Plastik','price_per_kg'=>5000,'description'=>'Botol air mineral bekas bersih tanpa label','status'=>'active'],
 ['name'=>'Kertas Dupleks / Dus','category'=>'Kardus','price_per_kg'=>2500,'description'=>'Kardus bekas kemasan, bersih dan kering','status'=>'active'],
 ['name'=>'Kertas HVS / Buku','category'=>'Kertas','price_per_kg'=>3000,'description'=>'Kertas putih bekas cetak atau buku tulis','status'=>'active'],
 ['name'=>'Kaleng / Besi Tipis','category'=>'Logam','price_per_kg'=>8000,'description'=>'Kaleng minuman atau wadah makanan logam','status'=>'active']]);
 }}
