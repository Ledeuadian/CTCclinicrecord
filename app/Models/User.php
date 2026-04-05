<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Patients;
use App\Models\Doctors;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email',
        'user_type',
        'password',
        'f_name',
        'm_name',
        'l_name',
        'dob',
        'address',
        'gender',
        'contact_no',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User to Patient Relationship (One-to-One)
     */
    public function patient()
    {
        return $this->hasOne(Patients::class,'user_id','id');
    }

    /**
     * User to Doctor Relationship (One-to-One)
     */
    public function doctor()
    {
        return $this->hasOne(Doctors::class,'user_id','id');
    }
}
