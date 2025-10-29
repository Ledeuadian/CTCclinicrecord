<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Patients;

class ImmunizationRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_name',
        'vaccine_type',
        'administered_by',
        'dosage',
        'site_of_administration',
        'expiration_date',
        'notes',
        'patient_id',
    ];

    /**
     * Immunization Records to Patient Relationship (Foreign Key)
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patients::class,'patient_id','id');
    }
}
