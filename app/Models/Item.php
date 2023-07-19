<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'name',
        'price',
        'cost',
        'VAT',
        'discount',
        'quantity',
        'is_deleted'
    ];
}
