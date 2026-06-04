<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'location',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }
}
