<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sale;

class PaymentMethod extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentMethodFactory> */
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
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
