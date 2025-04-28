<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'damage_types',
        'damage_description',
        'severity',
        'repair_cost',
        'violation_fee',
        'insurance_claim',
        'damage_photos',
        'assessment_date',
    ];

    protected $casts = [
        'damage_photos' => 'array',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
