<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'notify_max_temp' => 'boolean',
        'notify_daily_limit' => 'boolean',
        'daily_limit' => 'integer',
        'max_temp' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withPivot('notifications');
    }

    public function setMaxTempAttribute($value)
    {
        $this->attributes['max_temp'] = $value * 10;
    }

    public function getMaxTempAttribute($value)
    {
        return $value / 10;
    }
}
