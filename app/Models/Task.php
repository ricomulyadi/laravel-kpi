<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'task_code',
        'user_id',
        'source',
        'department',
        'project_name',
        'task_type',
        'task_name',
        'brief',
        'deadline',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
