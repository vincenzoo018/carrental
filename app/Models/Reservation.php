<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservation_id';
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'pickup_location',
        'payment_status',

    ];

    public function getPaymentStatusLabelAttribute()
    {
        $totalPaid = $this->payments()->where('payment_status', 'Paid')->sum('amount');
        if ($totalPaid >= $this->total_price) {
            return 'Paid';
        } elseif ($totalPaid >= ($this->total_price / 2)) {
            return 'Partially Paid';
        } else {
            return 'Pending';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'car_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'reservation_id');
    }

    public function maintenance()
    {
        return $this->hasOne(Maintenance::class, 'reservation_id');
    }
    public function damage()
    {
        return $this->hasMany(Damage::class);
    }
}
