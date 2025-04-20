<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $primaryKey = 'car_id';
    public $incrementing = true; // Because car_id is an integer primary key
    protected $keyType = 'int';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'plate_number',
        'price',
        'status',
        'mileage',
        'photo',
    ];

    // Car statuses
    const STATUS_AVAILABLE = 'available';
    const STATUS_RENTED = 'rented';
    const STATUS_MAINTENANCE = 'maintenance';

    // (Optional) Car types if you ever include it in DB
    const TYPE_ECONOMY = 'economy';
    const TYPE_LUXURY = 'luxury';
    const TYPE_SUV = 'suv';
    const TYPE_SPORTS = 'sports';

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'car_id');
    }

    // Accessor for full photo URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/car_photos/' . $this->photo)
            : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    }

    // Get Bootstrap badge class for status
    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'bg-success',
            self::STATUS_RENTED => 'bg-warning',
            self::STATUS_MAINTENANCE => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
