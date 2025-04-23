<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceHistory extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'performed_at',
        'report',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
