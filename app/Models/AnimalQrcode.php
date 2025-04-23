<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalQrcode extends Model
{
    /** @use HasFactory<\Database\Factories\AnimalQrcodeFactory> */
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'qr_code_path',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
