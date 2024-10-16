<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VaccinationCenter extends Model
{
    use hasFactory;
    const ACTIVE = 1;

    protected $table = 'vaccination_centers';

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
    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class);
    }
}
