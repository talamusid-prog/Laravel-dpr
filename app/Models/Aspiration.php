<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Aspiration extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'submitter_name',
        'submitter_email',
        'submitter_phone',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'baru');
    }

    public function markAsResponded(string $response): void
    {
        $this->update([
            'admin_response' => $response,
            'responded_at' => now(),
        ]);
    }
}
