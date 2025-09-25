<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'project_id',
        'date',
        'start_time',
        'end_time',
        'duration_minutes',
        'description',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'duration_minutes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getDurationHoursAttribute()
    {
        return round($this->duration_minutes / 60, 2);
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        
        return "{$minutes}m";
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function calculateDuration()
    {
        if ($this->end_time) {
            $start = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->start_time->format('H:i:s'));
            $end = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->end_time->format('H:i:s'));
            $this->duration_minutes = $end->diffInMinutes($start);
        }
    }
}
