<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Patients;

class PrescriptionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosage',
        'instruction',
        'patient_id',
        'doctor_id',
        'medicine_id',
    ];

    /**
     * Prescription Records to Patient Relationsip (Foreign Key)
     */
    public function Patients(): BelongsTo
    {
        return $this->belongsTo(Patients::class,'patient_id','id');
    }

    /**
     * Prescription Records to Patient Relationship (Alias for controller usage)
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patients::class,'patient_id','id');
    }
}
