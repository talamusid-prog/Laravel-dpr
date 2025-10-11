<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Analytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'views',
        'unique_visitors',
        'session_duration',
        'metadata',
        'date',
    ];

    protected $casts = [
        'metadata' => 'array',
        'date' => 'date',
    ];

    public function scopeByPage(Builder $query, string $page): Builder
    {
        return $query->where('page', $page);
    }

    public function scopeByDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('date', today());
    }
}
