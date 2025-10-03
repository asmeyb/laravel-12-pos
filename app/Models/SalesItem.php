<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesItem extends Model
{
    /** @use HasFactory<\Database\Factories\SalesItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_id',
        'item_id',
        'quantity',
        'price',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
