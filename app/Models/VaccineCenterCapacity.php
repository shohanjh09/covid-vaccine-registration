<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenterCapacity extends Model
{
    protected $table = 'vaccine_center_capacity';

    protected $primaryKey = 'id';

    protected $fillable = [
        'vaccine_center_id',
        'date',
        'remaining_capacity'
    ];

    /**
     * Get the vaccine center that owns this capacity record.
     */
    public function vaccineCenter()
    {
        return $this->belongsTo(VaccineCenter::class);
    }
}
