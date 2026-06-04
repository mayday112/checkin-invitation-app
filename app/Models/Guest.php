<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'guest_code',
        'name',
        'phone',
        'quota',
        'status',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'quota' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }
}
