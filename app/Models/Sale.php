<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Item;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\SalesItem;

class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'payment_method_id',
        'total',
        'paid_amount',
        'discount',
        'created_by'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SalesItem::class);
    }

    public function soldBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
