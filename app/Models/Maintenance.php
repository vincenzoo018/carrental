<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $primaryKey = 'maintenance_id';

    protected $fillable = [
        'damage_id',
        'reservation_id',
        'damage',
        'warranty_contract',
        'date_of_return',
    ];

    // Relationship to the associated damage record
    public function damage()
    {
        return $this->belongsTo(\App\Models\Damage::class, 'damage_id', 'id');
    }

    // Relationship to the associated reservation
    public function reservation()
    {
        return $this->belongsTo(\App\Models\Reservation::class, 'reservation_id', 'reservation_id');
    }

    // (Optional) All damages for the same reservation
    public function damages()
    {
        return $this->hasMany(\App\Models\Damage::class, 'reservation_id', 'reservation_id');
    }
}
