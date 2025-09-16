<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 
    'title',
    'experience_level',
    'skills',
    'bio', 
     'rating',
    'active_tasks',
    'completed_projects',
    'hours_logged',
   ];

    protected $casts = [
        'rating' => 'decimal:1',
        'active_tasks' => 'integer',
        'completed_projects' => 'integer',
        'hours_logged' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function getSkillsArrayAttribute()
    {
        return $this->skills ? explode(',', $this->skills) : [];
    }

    public function getRatingStarsAttribute()
    {
        return str_repeat('⭐', (int)$this->rating);
    }
}
