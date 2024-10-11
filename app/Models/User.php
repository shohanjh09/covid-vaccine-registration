<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nid',
        'vaccination_center_id',
    ];

    /**
     * Relationship: A user has one vaccination record.
     */
    public function vaccination() : HasOne
    {
        return $this->hasOne(Vaccination::class);
    }

    /**
     * Relationship: A user belongs to a vaccine center.
     */
    public function VaccinationCenter(): BelongsTo
    {
        return $this->belongsTo(VaccinationCenter::class, 'vaccination_center_id');
    }
}
