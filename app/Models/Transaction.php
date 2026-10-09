<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
    protected $table='transactions'; public $timestamps=false;
    protected $fillable=['user_id','deposit_id','type','amount','description'];
    protected $casts=['amount'=>'decimal:2'];
    public function user(){return $this->belongsTo(User::class);}
    public function deposit(){return $this->belongsTo(Deposit::class);}
}
