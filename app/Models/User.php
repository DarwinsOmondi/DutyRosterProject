<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * Check if the user has the janitor role.
     *
     * @return bool
     */
    public function isJanitor()
    {
        return $this->role === 'janitor';
    }

    /**
     * Check if the user has the manager role.
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }
}
