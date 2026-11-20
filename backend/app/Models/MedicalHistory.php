<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalHistory extends Model
{
    protected $fillable = [
        'user_id',
        'blood_group',
        'previous_diseases',
        'allergies',
        'current_medications',
        'past_surgeries',
        'family_medical_history',
        'additional_notes',
    ];

    // Medical History belongs to one Patient
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
