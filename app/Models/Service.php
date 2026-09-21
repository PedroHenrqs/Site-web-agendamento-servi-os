<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "price_cents",
        "active",
    ];

    protected function casts(): array
    {
        return [
            "active" => "boolean",
        ];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return "R$ " . number_format($this->price_cents / 100, 2, ",", ".");
    }
}
