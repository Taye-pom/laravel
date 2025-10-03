<?php

namespace App\Livewire;

use App\Models\TimeEntry;
use App\Models\Task;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeTracking extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $selectedEntry = null;
    public $filterDate = '';
    public $filterProject = '';

    // Time entry fields
    public $task_id = '';
    public $project_id = '';
    public $date = '';
    public $start_time = '';
    public $end_time = '';
    public $description = '';

    protected $rules = [
        'task_id' => 'nullable|exists:tasks,id',
        'project_id' => 'required|exists:projects,id',
        'date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'nullable|after:start_time',
        'description' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->start_time = now()->format('H:i');
    }

    public function render()
    {
        $query = TimeEntry::with(['task', 'project'])
            ->where('user_id', Auth::id());

        if ($this->filterDate) {
            $query->where('date', $this->filterDate);
        }

        if ($this->filterProject) {
            $query->where('project_id', $this->filterProject);
        }

        $timeEntries = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        $projects = Project::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $tasks = Task::where('assigned_to', Auth::id())
            ->where('status', '!=', 'completed')
            ->get();

        // Get today's active entry
        $activeEntry = TimeEntry::where('user_id', Auth::id())
            ->where('date', now()->format('Y-m-d'))
            ->where('status', 'active')
            ->first();

        // Get statistics
        $stats = $this->getTimeStats();

        return view('livewire.time-tracking', [
            'timeEntries' => $timeEntries,
            'projects' => $projects,
            'tasks' => $tasks,
            'activeEntry' => $activeEntry,
            'stats' => $stats,
        ]);
    }

    public function startTimer()
    {
        // Check if project is selected
        if (!$this->project_id) {
            session()->flash('error', 'Veuillez sélectionner un projet avant de démarrer le timer.');
            return;
        }

        $this->validate([
            'project_id' => 'required|exists:projects,id',
            'task_id' => 'nullable|exists:tasks,id',
            'description' => 'nullable|string|max:500',
        ]);

        // Stop any active timer first
        $this->stopActiveTimer();

        TimeEntry::create([
            'user_id' => Auth::id(),
            'task_id' => $this->task_id ?: null,
            'project_id' => $this->project_id,
            'date' => now()->format('Y-m-d'),
            'start_time' => now()->format('H:i:s'),
            'description' => $this->description,
            'status' => 'active',
        ]);

        $this->reset(['task_id', 'project_id', 'description']);
        session()->flash('message', 'Timer démarré !');
    }

    public function stopTimer(TimeEntry $entry)
    {
        $entry->update([
            'end_time' => now()->format('H:i:s'),
            'status' => 'completed',
        ]);

        $entry->calculateDuration();
        $entry->save();

        session()->flash('message', 'Timer arrêté !');
    }

    public function pauseTimer(TimeEntry $entry)
    {
        $entry->update(['status' => 'paused']);
        session()->flash('message', 'Timer mis en pause !');
    }

    public function resumeTimer(TimeEntry $entry)
    {
        $entry->update(['status' => 'active']);
        session()->flash('message', 'Timer repris !');
    }

    public function stopActiveTimer()
    {
        $activeEntry = TimeEntry::where('user_id', Auth::id())
            ->where('date', now()->format('Y-m-d'))
            ->where('status', 'active')
            ->first();

        if ($activeEntry) {
            $this->stopTimer($activeEntry);
        }
    }

    public function create()
    {
        $this->reset(['task_id', 'project_id', 'description']);
        $this->date = now()->format('Y-m-d');
        $this->start_time = now()->format('H:i');
        $this->end_time = '';
        $this->showCreateModal = true;
    }

    public function edit(TimeEntry $entry)
    {
        $this->selectedEntry = $entry;
        $this->task_id = $entry->task_id;
        $this->project_id = $entry->project_id;
        $this->date = $entry->date->format('Y-m-d');
        $this->start_time = $entry->start_time->format('H:i');
        $this->end_time = $entry->end_time ? $entry->end_time->format('H:i') : '';
        $this->description = $entry->description;
        $this->showEditModal = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'task_id' => $this->task_id ?: null,
            'project_id' => $this->project_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'description' => $this->description,
            'status' => $this->end_time ? 'completed' : 'active',
        ];

        $entry = TimeEntry::create($data);

        if ($this->end_time) {
            $entry->calculateDuration();
            $entry->save();
        }

        $this->showCreateModal = false;
        $this->reset(['task_id', 'project_id', 'date', 'start_time', 'end_time', 'description']);
        session()->flash('message', 'Entrée de temps créée !');
    }

    public function update()
    {
        $this->validate();

        $data = [
            'task_id' => $this->task_id ?: null,
            'project_id' => $this->project_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'description' => $this->description,
            'status' => $this->end_time ? 'completed' : 'active',
        ];

        $this->selectedEntry->update($data);

        if ($this->end_time) {
            $this->selectedEntry->calculateDuration();
            $this->selectedEntry->save();
        }

        $this->showEditModal = false;
        session()->flash('message', 'Entrée de temps mise à jour !');
    }

    public function delete(TimeEntry $entry)
    {
        $entry->delete();
        session()->flash('message', 'Entrée de temps supprimée !');
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->reset(['task_id', 'project_id', 'date', 'start_time', 'end_time', 'description']);
    }

    private function getTimeStats()
    {
        $today = now()->format('Y-m-d');
        $thisWeek = now()->startOfWeek()->format('Y-m-d');
        $thisMonth = now()->startOfMonth()->format('Y-m-d');

        return [
            'today' => TimeEntry::where('user_id', Auth::id())
                ->where('date', $today)
                ->where('status', 'completed')
                ->sum('duration_minutes'),
            'thisWeek' => TimeEntry::where('user_id', Auth::id())
                ->where('date', '>=', $thisWeek)
                ->where('status', 'completed')
                ->sum('duration_minutes'),
            'thisMonth' => TimeEntry::where('user_id', Auth::id())
                ->where('date', '>=', $thisMonth)
                ->where('status', 'completed')
                ->sum('duration_minutes'),
        ];
    }
}
