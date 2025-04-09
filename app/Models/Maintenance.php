<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    protected $primaryKey = 'maintenance_id';
    protected $table = 'maintenance';

    protected $fillable = [
        'reservation_id',
        'damage',
        'warranty_contract',
        'date_of_return',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date_of_return' => 'date',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'reservation_id');
    }

    public function car(): BelongsTo
    {
        return $this->reservation->car();
    }
}
