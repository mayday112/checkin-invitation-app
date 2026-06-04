<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'file_name',
        'total_rows',
        'successful_rows',
        'failed_rows',
    ];

    protected $casts = [
        'total_rows' => 'integer',
        'successful_rows' => 'integer',
        'failed_rows' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
