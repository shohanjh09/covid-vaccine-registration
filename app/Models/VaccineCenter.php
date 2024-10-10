<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class VaccineCenter extends Model
{
    const ACTIVE = 1;

    protected $table = 'vaccine_centers';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'location',
        'daily_capacity',
    ];

    /**
     * Relationship: A vaccine center has many vaccinations.
     */
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }
}
