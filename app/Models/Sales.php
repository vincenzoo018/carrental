<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $primaryKey = 'sales_id';
    protected $fillable = [
        'employee_id',
        'booking_id',
        'reservation_id',
        'date',
        'total_sales',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function reservation()
    {
        return $this->belongsTo(\App\Models\Reservation::class, 'reservation_id');
    }

    public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id');
    }
}
