<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Doctors extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'address',
    ];

    /**
     * Get the user that owns the Doctors
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
