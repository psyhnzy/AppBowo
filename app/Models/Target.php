<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    protected $table = 'targets';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'target_weight',
        'period'
    ];

    protected $casts = [
        'target_weight' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
