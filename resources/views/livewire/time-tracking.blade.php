<div class="time-tracking">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-clock me-2"></i>Suivi du Temps</h2>
        <div>
            <button class="btn btn-success me-2" wire:click="create">
                <i class="fas fa-plus me-2"></i>Nouvelle entrée
            </button>
            @if($activeEntry)
                <button class="btn btn-danger" wire:click="stopTimer({{ $activeEntry->id }})">
                    <i class="fas fa-stop me-2"></i>Arrêter le timer
                </button>
            @else
                <button class="btn btn-primary" wire:click="startTimer">
                    <i class="fas fa-play me-2"></i>Démarrer le timer
                </button>
            @endif
        </div>
    </div>

    <!-- Quick Timer Form -->
    @if(!$activeEntry)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-stopwatch me-2"></i>Timer Rapide</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Projet *</label>
                        <select class="form-select" wire:model="project_id">
                            <option value="">Sélectionner un projet</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tâche</label>
                        <select class="form-select" wire:model="task_id">
                            <option value="">Aucune tâche</option>
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" wire:model="description" placeholder="Description optionnelle">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Active Timer -->
    @if($activeEntry)
        <div class="alert alert-info mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Timer actif :</strong> {{ $activeEntry->project->name }}
                    @if($activeEntry->task)
                        - {{ $activeEntry->task->title }}
                    @endif
                    <br>
                    <small>Démarré à {{ $activeEntry->start_time->format('H:i') }}</small>
                </div>
<div>
                    <button class="btn btn-warning btn-sm me-2" wire:click="pauseTimer({{ $activeEntry->id }})">
                        <i class="fas fa-pause"></i> Pause
                    </button>
                    <button class="btn btn-danger btn-sm" wire:click="stopTimer({{ $activeEntry->id }})">
                        <i class="fas fa-stop"></i> Arrêter
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ round($stats['today'] / 60, 1) }}h</h5>
                    <p class="card-text">Aujourd'hui</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ round($stats['thisWeek'] / 60, 1) }}h</h5>
                    <p class="card-text">Cette semaine</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ round($stats['thisMonth'] / 60, 1) }}h</h5>
                    <p class="card-text">Ce mois</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="date" class="form-control" wire:model="filterDate" placeholder="Filtrer par date">
        </div>
        <div class="col-md-4">
            <select class="form-select" wire:model="filterProject">
                <option value="">Tous les projets</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-outline-secondary w-100" wire:click="$set('filterDate', '')">
                <i class="fas fa-times me-2"></i>Effacer les filtres
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Time Entries List -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des entrées</h5>
        </div>
        <div class="card-body">
            @forelse($timeEntries as $entry)
                <div class="time-entry-item mb-3 p-3 border rounded">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-1">{{ $entry->project->name }}</h6>
                            @if($entry->task)
                                <small class="text-muted">{{ $entry->task->title }}</small>
                            @endif
                            @if($entry->description)
                                <p class="mb-0 text-muted small">{{ $entry->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-{{ $entry->status === 'completed' ? 'success' : ($entry->status === 'active' ? 'primary' : 'warning') }}">
                                {{ ucfirst($entry->status) }}
                            </span>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">
                                {{ $entry->date->format('d/m/Y') }}<br>
                                {{ $entry->start_time->format('H:i') }} - {{ $entry->end_time ? $entry->end_time->format('H:i') : 'En cours' }}
                            </small>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex justify-content-end gap-2">
                                @if($entry->status === 'paused')
                                    <button class="btn btn-sm btn-success" wire:click="resumeTimer({{ $entry->id }})">
                                        <i class="fas fa-play"></i>
                                    </button>
                                @endif
                                <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $entry->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" wire:click="delete({{ $entry->id }})"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($entry->duration_minutes > 0)
                        <div class="mt-2">
                            <strong>Durée :</strong> {{ $entry->formatted_duration }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune entrée de temps</h4>
                    <p class="text-muted">Commencez par créer votre première entrée !</p>
                    <button class="btn btn-primary" wire:click="create">
                        <i class="fas fa-plus me-2"></i>Créer une entrée
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $timeEntries->links() }}
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nouvelle entrée de temps</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label class="form-label">Projet *</label>
                                <select class="form-select" wire:model="project_id" required>
                                    <option value="">Sélectionner un projet</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tâche</label>
                                <select class="form-select" wire:model="task_id">
                                    <option value="">Aucune tâche</option>
                                    @foreach($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" class="form-control" wire:model="date" required>
                                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Heure de début *</label>
                                        <input type="time" class="form-control" wire:model="start_time" required>
                                        @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" wire:model="end_time">
                                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" wire:model="description" rows="3"></textarea>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier l'entrée de temps</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update">
                            <div class="mb-3">
                                <label class="form-label">Projet *</label>
                                <select class="form-select" wire:model="project_id" required>
                                    <option value="">Sélectionner un projet</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tâche</label>
                                <select class="form-select" wire:model="task_id">
                                    <option value="">Aucune tâche</option>
                                    @foreach($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" class="form-control" wire:model="date" required>
                                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Heure de début *</label>
                                        <input type="time" class="form-control" wire:model="start_time" required>
                                        @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" wire:model="end_time">
                                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" wire:model="description" rows="3"></textarea>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

<style>
.time-entry-item {
    transition: background-color 0.2s;
}

.time-entry-item:hover {
    background-color: #f8f9fa;
}

.time-entry-item.active {
    border-left: 4px solid #007bff;
}
</style>