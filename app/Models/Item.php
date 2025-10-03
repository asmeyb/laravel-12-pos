<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SalesItem;
use App\Models\Inventory;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'status',
        'image',
        'created_by', 
        'updated_by'
    ];

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SalesItem::class);
    }
}
