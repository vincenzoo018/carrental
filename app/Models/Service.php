<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'service_name',
        'description',
        'price',
        'employee_id',
    ];

    // Relationship: A service belongs to an employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relationship: A service can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }
}
