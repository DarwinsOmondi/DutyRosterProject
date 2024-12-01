<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    // Define the attributes that can be mass-assigned (Eloquent mass-assignment protection)
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'assigned_to',
        'time' // assuming assigned_to is a foreign key referencing the users table
    ];

    // Define the relationship between Duty and User
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to'); // `assigned_to` references `users` table's `id`
    }
}
