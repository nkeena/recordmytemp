<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function temperatures()
    {
        return $this->hasMany(Temperature::class);
    }

    public function currentLog()
    {
        return $this->belongsTo(Log::class, 'current_log_id');
    }

    public function availableLogs()
    {
        return $this->belongsToMany(Log::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function getIsOwnerAttribute()
    {
        return optional($this->currentLog)->user_id === $this->id;
    }
}
