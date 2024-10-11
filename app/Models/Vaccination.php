<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    protected $table = 'vaccinations';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'scheduled_date',
    ];

    /**
     * Relationship: A vaccination belongs to a user.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
