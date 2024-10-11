<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccineCenterCapacity extends Model
{
    protected $table = 'vaccination_center_capacity';

    protected $primaryKey = 'id';

    protected $fillable = [
        'vaccination_center_id',
        'date',
        'remaining_capacity'
    ];

    /**
     * Get the vaccine center that owns this capacity record.
     */
    public function vaccineCenter() : BelongsTo
    {
        return $this->belongsTo(VaccinationCenter::class);
    }
}
