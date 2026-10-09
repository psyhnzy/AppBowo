<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Target extends Model
{
    protected $table='targets'; public $timestamps=false;
    protected $fillable=['user_id','target_weight','period'];
    protected $casts=['target_weight'=>'decimal:2'];
    public function user(){return $this->belongsTo(User::class);}
}
