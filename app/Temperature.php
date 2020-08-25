<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temperature extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function log()
    {
        return $this->belongsTo(Log::class);
    }

    public function setTemperatureAttribute($value)
    {
        $this->attributes['temperature'] = $value * 10;
    }

    public function getTemperatureAttribute($value)
    {
        return $value / 10;
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%$search%"));
    }

    public function scopeToday(Builder $query)
    {
        $query->whereBetween('created_at', [
            today($this->getUserTimezone())->timezone('UTC'),
            today($this->getUserTimezone())->endOfDay()->timezone('UTC')
        ]);
    }

    public function scopeYesterday(Builder $query)
    {
        $query->whereBetween('created_at', [
            today($this->getUserTimezone())->subDay()->timezone('UTC'),
            today($this->getUserTimezone())->endOfDay()->subDay()->timezone('UTC'),
        ]);
    }

    public function scopeThisWeek(Builder $query)
    {
        $query->whereBetween('created_at', [
            today($this->getUserTimezone())->startOfWeek()->timezone('UTC'),
            today($this->getUserTimezone())->endOfWeek()->endOfDay()->timezone('UTC')
        ]);
    }

    public function scopeThisMonth(Builder $query)
    {
        $query->whereBetween('created_at', [
            today($this->getUserTimezone())->startOfMonth()->timezone('UTC'),
            today($this->getUserTimezone())->endOfMonth()->endOfDay()->timezone('UTC')
        ]);
    }

    public function scopeDateRange(Builder $query, $startDate, $endDate)
    {
        $query->whereBetween('created_at', [
            Carbon::parse($startDate, $this->getUserTimezone())->timezone('UTC'),
            Carbon::parse($endDate, $this->getUserTimezone())->endOfDay()->timezone('UTC')
        ]);
    }

    private function getUserTimezone()
    {
        return auth()->check() && auth()->user()->timezone ? auth()->user()->timezone : 'UTC';
    }
}
