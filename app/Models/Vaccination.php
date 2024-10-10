<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccination extends Model
{
    use HasFactory;

    protected $table = 'vaccinations';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'vaccine_center_id',
        'scheduled_date',
        'vaccinated',
    ];

    /**
     * Relationship: A vaccination belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A vaccination belongs to a vaccine center.
     */
    public function vaccineCenter()
    {
        return $this->belongsTo(VaccineCenter::class);
    }
}
