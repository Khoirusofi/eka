<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Automatically generate a 5-digit registration number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            // Generate a new registration number
            $latestPatient = self::orderBy('no_registrasi', 'desc')->first();
            $nextNoRegistrasi = $latestPatient ? intval($latestPatient->no_registrasi) + 1 : 1;
            $patient->no_registrasi = str_pad($nextNoRegistrasi, 5, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Accessor to ensure the registration number is always 5 digits.
     */
    public function getNoRegistrasiAttribute($value)
    {
        return str_pad($value, 5, '0', STR_PAD_LEFT);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Relationship between patient and user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * Relationship between patient and appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
