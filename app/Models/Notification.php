<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'read' => false,
            'read_at' => null,
        ]);
    }

    public function getIconAttribute()
    {
        return match($this->type) {
            'task_assigned' => 'fas fa-tasks',
            'task_completed' => 'fas fa-check-circle',
            'project_updated' => 'fas fa-project-diagram',
            'time_entry_created' => 'fas fa-clock',
            'user_mentioned' => 'fas fa-at',
            default => 'fas fa-bell',
        };
    }

    public function getColorAttribute()
    {
        return match($this->type) {
            'task_assigned' => 'primary',
            'task_completed' => 'success',
            'project_updated' => 'info',
            'time_entry_created' => 'warning',
            'user_mentioned' => 'danger',
            default => 'secondary',
        };
    }
}
