<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'position',
        'hourly_rate',
        'hire_date',
        'is_active',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'hire_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(StaffAttendance::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTotalHoursThisMonth()
    {
        return $this->attendance()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('hours_worked');
    }

    public function getTotalPayThisMonth()
    {
        return $this->attendance()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_pay');
    }
}