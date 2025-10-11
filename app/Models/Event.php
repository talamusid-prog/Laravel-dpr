<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'start_date',
        'end_date',
        'location',
        'participants',
        'send_reminder',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'participants' => 'array',
        'send_reminder' => 'boolean',
    ];

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('start_date', today());
    }

    public function isUpcoming(): bool
    {
        return $this->start_date > now();
    }

    public function isToday(): bool
    {
        return $this->start_date->isToday();
    }
}
