<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Deposit extends Model
{
    protected $table='deposits'; public $timestamps=false;
    protected $fillable=['user_id','waste_type_id','weight','price_per_kg','total_value','points','deposit_date','notes','status','verified_by','verified_at'];
    protected $casts=['weight'=>'decimal:2','price_per_kg'=>'decimal:2','total_value'=>'decimal:2','deposit_date'=>'date','verified_at'=>'datetime'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function wasteType(): BelongsTo { return $this->belongsTo(WasteType::class,'waste_type_id'); }
    public function verifier(): BelongsTo { return $this->belongsTo(User::class,'verified_by'); }
    public function transaction() { return $this->hasOne(Transaction::class); }
}
