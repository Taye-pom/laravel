<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'project_id',
        'assigned_to',
        'created_by',
        'due_date',
        'estimated_hours',
        'actual_hours',
        'notes',
    ];

    protected $casts = [
        'due_date'       => 'date',
        'estimated_hours'=> 'integer',
        'actual_hours'   => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
        public function isOverdue()
    {
        return $this->due_date && $this->due_date < Carbon::today() && $this->status !== 'done';
    }
}
