<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "time",
        "available",
    ];

    protected function casts(): array
    {
        return [
            "date" => "date",
            "available" => "boolean",
        ];
    }
}
