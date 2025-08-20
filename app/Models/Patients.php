<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\ImmunizationRecords;
use App\Models\PrescriptionRecord;

class Patients extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_type',
        'edulvl_id',
        'user_id',
        'school_id',
        'address',
        'medical_condition',
        'medical_illness',
        'operations',
        'allergies',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_relationship',
    ];

    /**
     * Patient to User Relationship (Foreign Key)
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Patient to User Relationship (Foreign Key)
     */
    public function immunization()
    {
        return $this->hasOne(ImmunizationRecords::class,'patient_id','id');
    }

    /**
     * Patient to Prescription Record Relationship (Foreign Key)
     */
    public function prescription()
    {
        return $this->hasOne(PrescriptionRecord::class,'patient_id','id');
    }

    /**
     * Patient to Appointments Relationship (One-to-Many)
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }
}
