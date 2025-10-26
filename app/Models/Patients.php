<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\ImmunizationRecords;
use App\Models\PrescriptionRecord;
use App\Models\DentalExamination;
use App\Models\PhysicalExamination;
use App\Models\HealthRecords;

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
     * Patient to Dental Examination Relationship (One-to-Many)
     */
    public function dentalExaminations(): HasMany
    {
        return $this->hasMany(DentalExamination::class, 'patient_id', 'id');
    }

    /**
     * Patient to Physical Examination Relationship (One-to-Many)
     */
    public function physicalExaminations(): HasMany
    {
        return $this->hasMany(PhysicalExamination::class, 'patient_id', 'id');
    }

    /**
     * Patient to Health Records Relationship (One-to-Many)
     */
    public function healthRecords(): HasMany
    {
        return $this->hasMany(HealthRecords::class, 'patient_id', 'id');
    }

    /**
     * Patient to Appointments Relationship (One-to-Many)
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }
}
