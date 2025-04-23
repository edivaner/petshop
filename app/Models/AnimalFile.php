<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalFile extends Model
{
    /** @use HasFactory<\Database\Factories\AnimalFileFactory> */
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'file_path',
        'type',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
