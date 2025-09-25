<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TaskManagement extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $selectedTask = null;
    public $filterStatus = '';
    public $filterPriority = '';
    public $filterProject = '';

    // Task form fields
    public $title = '';
    public $description = '';
    public $project_id = '';
    public $assigned_to = '';
    public $priority = 'medium';
    public $due_date = '';
    public $estimated_hours = '';
    public $notes = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'project_id' => 'required|exists:projects,id',
        'assigned_to' => 'nullable|exists:users,id',
        'priority' => 'required|in:low,medium,high,urgent',
        'due_date' => 'nullable|date|after:today',
        'estimated_hours' => 'nullable|integer|min:1',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $query = Task::with(['project', 'assignedTo', 'creator'])
            ->where('assigned_to', Auth::id());

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        if ($this->filterProject) {
            $query->where('project_id', $this->filterProject);
        }

        $tasks = $query->orderBy('due_date', 'asc')->paginate(10);

        $projects = Project::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $developers = User::where('role', 'developer')->get();

        return view('livewire.task-management', [
            'tasks' => $tasks,
            'projects' => $projects,
            'developers' => $developers,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function edit(Task $task)
    {
        $this->selectedTask = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->project_id = $task->project_id;
        $this->assigned_to = $task->assigned_to;
        $this->priority = $task->priority;
        $this->due_date = $task->due_date?->format('Y-m-d');
        $this->estimated_hours = $task->estimated_hours;
        $this->notes = $task->notes;
        $this->showEditModal = true;
    }

    public function store()
    {
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->project_id,
            'assigned_to' => $this->assigned_to ?: Auth::id(),
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'estimated_hours' => $this->estimated_hours,
            'notes' => $this->notes,
            'created_by' => Auth::id(),
            'status' => 'todo',
        ]);

        $this->resetForm();
        $this->showCreateModal = false;
        session()->flash('message', 'Tâche créée avec succès !');
    }

    public function update()
    {
        $this->validate();

        $this->selectedTask->update([
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->project_id,
            'assigned_to' => $this->assigned_to,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'estimated_hours' => $this->estimated_hours,
            'notes' => $this->notes,
        ]);

        $this->resetForm();
        $this->showEditModal = false;
        session()->flash('message', 'Tâche mise à jour avec succès !');
    }

    public function updateStatus(Task $task, $status)
    {
        $task->update(['status' => $status]);
        session()->flash('message', 'Statut de la tâche mis à jour !');
    }

    public function delete(Task $task)
    {
        $task->delete();
        session()->flash('message', 'Tâche supprimée avec succès !');
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->project_id = '';
        $this->assigned_to = '';
        $this->priority = 'medium';
        $this->due_date = '';
        $this->estimated_hours = '';
        $this->notes = '';
        $this->selectedTask = null;
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->resetForm();
    }
}
