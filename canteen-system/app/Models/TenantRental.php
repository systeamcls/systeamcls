<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'monthly_rent',
        'due_date',
        'paid_date',
        'amount_paid',
        'status',
        'notes',
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'pending')
                  ->where('due_date', '<', now());
            });
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date < now();
    }
}