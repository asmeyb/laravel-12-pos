<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Item;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user who last updated the item.
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
