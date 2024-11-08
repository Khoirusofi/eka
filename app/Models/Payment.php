<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Relationship between payment and user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appoinment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
