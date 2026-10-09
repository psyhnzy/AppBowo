<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = ['name','username','email','phone','address','password','role','balance','points','status'];
    protected $hidden = ['password'];
    protected $casts = ['balance'=>'decimal:2'];
    public function deposits(): HasMany { return $this->hasMany(Deposit::class); }
    public function transactions(): HasMany { return $this->hasMany(Transaction::class); }
    public function target() { return $this->hasOne(Target::class); }
}
