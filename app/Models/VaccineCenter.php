<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vaccination;

class VaccineCenter extends Model
{
    use HasFactory;

    protected $table = 'vaccine_centers';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
