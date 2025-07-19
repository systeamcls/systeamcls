<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_amount',
        'status',
        'delivery_type',
        'payment_method',
        'payment_status',
        'delivery_address',
        'notes',
        'delivery_time',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'delivery_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->whereHas('orderItems.menuItem', function ($q) use ($tenantId) {
            $q->where('user_id', $tenantId);
        });
    }
}