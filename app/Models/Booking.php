<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';

    // Add this if booking_id is not auto-incrementing
    public $incrementing = true;

    // Also add this if your key is not of type int
    protected $keyType = 'int'; // or 'string' if applicable

    protected $fillable = [
        'user_id',
        'service_id',
        'date',
        'total_price',
        'status',
        'payment_status', // <-- add this if not present
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'booking_id', 'booking_id');
    }
}