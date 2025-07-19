<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'date',
        'clock_in',
        'clock_out',
        'hours_worked',
        'total_pay',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime:H:i',
        'clock_out' => 'datetime:H:i',
        'hours_worked' => 'decimal:2',
        'total_pay' => 'decimal:2',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function calculateHoursWorked()
    {
        if ($this->clock_in && $this->clock_out) {
            $clockIn = \Carbon\Carbon::parse($this->clock_in);
            $clockOut = \Carbon\Carbon::parse($this->clock_out);
            $this->hours_worked = $clockOut->diffInHours($clockIn, true);
            $this->total_pay = $this->hours_worked * $this->staff->hourly_rate;
            $this->save();
        }
    }
}