<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sales extends Model
{
    use HasFactory;

    protected $primaryKey = 'sales_id';

    protected $fillable = [
        'admin_id',
        'date',
        'total_sales',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'date',
        'total_sales' => 'decimal:2',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'admin_id', 'employee_id');
    }
}
