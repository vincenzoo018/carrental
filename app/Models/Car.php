<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'year' => 'integer',
        'price' => 'decimal:2',
        'mileage' => 'integer',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'car_id', 'car_id');
    }

    public function maintenanceRecords(): HasManyThrough
    {
        return $this->hasManyThrough(
            Maintenance::class,
            Reservation::class,
            'car_id',
            'reservation_id',
            'car_id',
            'reservation_id'
        );
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model} ({$this->year})";
    }
}