<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function invoice_details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
