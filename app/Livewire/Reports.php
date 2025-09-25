<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Reports extends Component
{
    public $selectedPeriod = 'week';
    public $selectedProject = '';
    public $startDate = '';
    public $endDate = '';

    public function mount()
    {
        $this->startDate = now()->startOfWeek()->format('Y-m-d');
        $this->endDate = now()->endOfWeek()->format('Y-m-d');
    }

    public function render()
    {
        $user = Auth::user();
        $projects = Project::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $dateRange = $this->getDateRange();
        
        $stats = $this->getStats($dateRange);
        $taskStats = $this->getTaskStats($dateRange);
        $timeStats = $this->getTimeStats($dateRange);
        $projectStats = $this->getProjectStats($dateRange);

        return view('livewire.reports', [
            'projects' => $projects,
            'stats' => $stats,
            'taskStats' => $taskStats,
            'timeStats' => $timeStats,
            'projectStats' => $projectStats,
            'dateRange' => $dateRange,
        ]);
    }

    public function updatedSelectedPeriod()
    {
        $this->updateDateRange();
    }

    private function updateDateRange()
    {
        switch ($this->selectedPeriod) {
            case 'today':
                $this->startDate = now()->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = now()->startOfWeek()->format('Y-m-d');
                $this->endDate = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'year':
                $this->startDate = now()->startOfYear()->format('Y-m-d');
                $this->endDate = now()->endOfYear()->format('Y-m-d');
                break;
        }
    }

    private function getDateRange()
    {
        return [
            'start' => Carbon::parse($this->startDate),
            'end' => Carbon::parse($this->endDate),
        ];
    }

    private function getStats($dateRange)
    {
        $user = Auth::user();
        
        return [
            'totalTasks' => Task::where('assigned_to', $user->id)
                ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
                ->count(),
            'completedTasks' => Task::where('assigned_to', $user->id)
                ->where('status', 'completed')
                ->whereBetween('updated_at', [$dateRange['start'], $dateRange['end']])
                ->count(),
            'totalHours' => TimeEntry::where('user_id', $user->id)
                ->whereBetween('date', [$dateRange['start']->format('Y-m-d'), $dateRange['end']->format('Y-m-d')])
                ->where('status', 'completed')
                ->sum('duration_minutes') / 60,
            'activeProjects' => Project::whereHas('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'active')->count(),
        ];
    }

    private function getTaskStats($dateRange)
    {
        $user = Auth::user();
        
        $tasks = Task::where('assigned_to', $user->id)
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get();

        return [
            'byStatus' => $tasks->groupBy('status')->map->count(),
            'byPriority' => $tasks->groupBy('priority')->map->count(),
            'overdue' => $tasks->filter(function($task) {
                return $task->isOverdue();
            })->count(),
        ];
    }

    private function getTimeStats($dateRange)
    {
        $user = Auth::user();
        
        $timeEntries = TimeEntry::where('user_id', $user->id)
            ->whereBetween('date', [$dateRange['start']->format('Y-m-d'), $dateRange['end']->format('Y-m-d')])
            ->where('status', 'completed')
            ->with('project')
            ->get();

        return [
            'totalMinutes' => $timeEntries->sum('duration_minutes'),
            'averagePerDay' => $timeEntries->groupBy('date')->map->sum('duration_minutes')->avg(),
            'byProject' => $timeEntries->groupBy('project.name')->map->sum('duration_minutes'),
            'dailyBreakdown' => $timeEntries->groupBy('date')->map->sum('duration_minutes'),
        ];
    }

    private function getProjectStats($dateRange)
    {
        $user = Auth::user();
        
        $projects = Project::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['tasks' => function($query) use ($user) {
            $query->where('assigned_to', $user->id);
        }])->get();

        return $projects->map(function($project) use ($dateRange) {
            $tasks = $project->tasks->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            $completedTasks = $tasks->where('status', 'completed');
            
            return [
                'name' => $project->name,
                'totalTasks' => $tasks->count(),
                'completedTasks' => $completedTasks->count(),
                'progress' => $tasks->count() > 0 ? round(($completedTasks->count() / $tasks->count()) * 100, 1) : 0,
            ];
        });
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'todo' => 'secondary',
            'in_progress' => 'primary',
            'review' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getPriorityColor($priority)
    {
        return match($priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'urgent' => 'dark',
            default => 'secondary',
        };
    }
}
