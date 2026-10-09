<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class WasteType extends Model
{
    protected $table='waste_types'; public $timestamps=false;
    protected $fillable=['name','category','price_per_kg','description','status'];
    protected $casts=['price_per_kg'=>'decimal:2'];
    public function deposits(): HasMany { return $this->hasMany(Deposit::class); }
}
