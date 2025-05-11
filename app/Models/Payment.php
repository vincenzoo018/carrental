<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // The primary key for the model
    protected $primaryKey = 'payment_id';

    // Allow mass assignment for these attributes
    protected $fillable = [
        'user_id',        // Assuming the payments table has a user_id column
        'reservation_id',
        'payment_date',
        'amount',
        'payment_status',
        'payment_method',
    ];

    // Automatically cast these fields to their appropriate types
    protected $casts = [
        'payment_date' => 'datetime', // Automatically convert payment_date to Carbon instance
        'amount' => 'decimal:2',      // Ensure the amount is a decimal with 2 places
    ];

    /**
     * Get the reservation that owns the payment.
     */
    public function reservation()
    {
        return $this->belongsTo(\App\Models\Reservation::class, 'reservation_id');
    }

    /**
     * Get the booking that owns the payment.
     */
    public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id');
    }

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
