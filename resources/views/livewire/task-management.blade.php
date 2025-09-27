    <div class="task-management">
        
    <style>
        .task-card {
            transition: transform 0.2s;
        }

        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .task-card.border-danger {
            border-left: 4px solid #dc3545 !important;
        }

        .task-meta {
            font-size: 0.85rem;
        }
    </style>
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tasks me-2"></i>Gestion des Tâches</h2>
            <button class="btn btn-primary" wire:click="create">
                <i class="fas fa-plus me-2"></i>Nouvelle Tâche
            </button>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-3">
                <select class="form-select" wire:model="filterStatus">
                    <option value="">Tous les statuts</option>
                    <option value="todo">À faire</option>
                    <option value="in_progress">En cours</option>
                    <option value="review">En révision</option>
                    <option value="completed">Terminé</option>
                    <option value="cancelled">Annulé</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" wire:model="filterPriority">
                    <option value="">Toutes les priorités</option>
                    <option value="low">Faible</option>
                    <option value="medium">Moyenne</option>
                    <option value="high">Élevée</option>
                    <option value="urgent">Urgente</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" wire:model="filterProject">
                    <option value="">Tous les projets</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100" wire:click="$set('filterStatus', '')">
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

        <!-- Tasks List -->
        <div class="row">
            @forelse($tasks as $task)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 task-card {{ $task->isOverdue() ? 'border-danger' : '' }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $task->status_badge }}">{{ ucfirst($task->status) }}</span>
                            <span class="badge bg-{{ $task->priority_badge }}">{{ ucfirst($task->priority) }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($task->description, 100) }}</p>
                            
                            <div class="task-meta mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-project-diagram me-1"></i>
                                            {{ $task->project->name }}
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        @if($task->due_date)
                                            <small class="text-muted {{ $task->isOverdue() ? 'text-danger' : '' }}">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $task->due_date->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                @if($task->estimated_hours)
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $task->estimated_hours }}h estimées
                                        </small>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Actions -->
                            <div class="btn-group w-100 mb-2" role="group">
                                @if($task->status !== 'todo')
                                    <button class="btn btn-sm btn-outline-secondary" 
                                            wire:click="updateStatus({{ $task->id }}, 'todo')">
                                        À faire
                                    </button>
                                @endif
                                @if($task->status !== 'in_progress')
                                    <button class="btn btn-sm btn-outline-primary" 
                                            wire:click="updateStatus({{ $task->id }}, 'in_progress')">
                                        En cours
                                    </button>
                                @endif
                                @if($task->status !== 'completed')
                                    <button class="btn btn-sm btn-outline-success" 
                                            wire:click="updateStatus({{ $task->id }}, 'completed')">
                                        Terminé
                                    </button>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill" 
                                        wire:click="edit({{ $task->id }})">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </button>
                                <button class="btn btn-sm btn-outline-danger" 
                                        wire:click="delete({{ $task->id }})"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Aucune tâche trouvée</h4>
                        <p class="text-muted">Commencez par créer votre première tâche !</p>
                        <button class="btn btn-primary" wire:click="create">
                            <i class="fas fa-plus me-2"></i>Créer une tâche
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $tasks->links() }}
        </div>
    </div>
