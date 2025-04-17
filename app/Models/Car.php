<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $primaryKey = 'car_id';
    protected $fillable = [
        'brand',
        'model',
        'year',
        'plate_number',
        'price',
        'status',
        'mileage',
        'photo',
        'type',
        'seats',
        'fuel_type',
        'transmission'
    ];

    // Car statuses
    const STATUS_AVAILABLE = 'available';
    const STATUS_RENTED = 'rented';
    const STATUS_MAINTENANCE = 'maintenance';

    // Car types
    const TYPE_ECONOMY = 'economy';
    const TYPE_LUXURY = 'luxury';
    const TYPE_SUV = 'suv';
    const TYPE_SPORTS = 'sports';

    // Relationship with reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'car_id');
    }

    // Accessor for photo URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/car_photos/' . $this->photo) :
            'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case self::STATUS_AVAILABLE:
                return 'bg-success';
            case self::STATUS_RENTED:
                return 'bg-warning';
            case self::STATUS_MAINTENANCE:
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }
}
