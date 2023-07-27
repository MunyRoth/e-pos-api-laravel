<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    public function purchasedBy (): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function billDetails (): HasMany
    {
        return $this->hasMany(BillDetail::class);
    }
}
