<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservation_id';

    protected $fillable = [
        'customer_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'service_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id', 'car_id');
    }


    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'reservation_id', 'reservation_id');
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'reservation_id', 'reservation_id');
    }

    public function getDurationAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
