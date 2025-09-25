<div class="reports">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chart-bar me-2"></i>Rapports et Analytics</h2>
        <div class="d-flex gap-2">
            <select class="form-select" wire:model="selectedPeriod" style="width: auto;">
                <option value="today">Aujourd'hui</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
                <option value="year">Cette année</option>
            </select>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Imprimer
            </button>
        </div>
    </div>

    <!-- Date Range -->
    <div class="row mb-4">
        <div class="col-md-6">
            <label class="form-label">Date de début</label>
            <input type="date" class="form-control" wire:model="startDate">
        </div>
        <div class="col-md-6">
            <label class="form-label">Date de fin</label>
            <input type="date" class="form-control" wire:model="endDate">
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                    <h3 class="text-primary">{{ $stats['totalTasks'] }}</h3>
                    <p class="text-muted">Tâches totales</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="text-success">{{ $stats['completedTasks'] }}</h3>
                    <p class="text-muted">Tâches terminées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                    <h3 class="text-info">{{ round($stats['totalHours'], 1) }}h</h3>
                    <p class="text-muted">Heures travaillées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-project-diagram fa-2x text-warning mb-2"></i>
                    <h3 class="text-warning">{{ $stats['activeProjects'] }}</h3>
                    <p class="text-muted">Projets actifs</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Task Statistics -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Statistiques des tâches</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Par statut</h6>
                            @foreach($taskStats['byStatus'] as $status => $count)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-{{ $this->getStatusColor($status) }}">{{ ucfirst($status) }}</span>
                                    <strong>{{ $count }}</strong>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h6>Par priorité</h6>
                            @foreach($taskStats['byPriority'] as $priority => $count)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-{{ $this->getPriorityColor($priority) }}">{{ ucfirst($priority) }}</span>
                                    <strong>{{ $count }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if($taskStats['overdue'] > 0)
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>{{ $taskStats['overdue'] }}</strong> tâche{{ $taskStats['overdue'] > 1 ? 's' : '' }} en retard
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Time Statistics -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Statistiques du temps</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Total travaillé</h6>
                        <h4 class="text-primary">{{ round($timeStats['totalMinutes'] / 60, 1) }}h</h4>
                    </div>
                    <div class="mb-3">
                        <h6>Moyenne par jour</h6>
                        <h5 class="text-info">{{ round($timeStats['averagePerDay'] / 60, 1) }}h</h5>
                    </div>
                    @if($timeStats['byProject']->count() > 0)
                        <h6>Par projet</h6>
                        @foreach($timeStats['byProject'] as $projectName => $minutes)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $projectName }}</span>
                                <strong>{{ round($minutes / 60, 1) }}h</strong>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Project Progress -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-project-diagram me-2"></i>Progrès des projets</h5>
                </div>
                <div class="card-body">
                    @forelse($projectStats as $project)
                        <div class="project-progress mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">{{ $project['name'] }}</h6>
                                <span class="badge bg-primary">{{ $project['progress'] }}%</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" style="width: {{ $project['progress'] }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted small">
                                <span>{{ $project['completedTasks'] }} / {{ $project['totalTasks'] }} tâches terminées</span>
                                <span>{{ $project['totalTasks'] - $project['completedTasks'] }} restantes</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-project-diagram fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Aucun projet trouvé pour cette période</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .form-select, .form-control {
        display: none !important;
    }
    
    .card {
        border: 1px solid #000 !important;
        break-inside: avoid;
    }
}

.project-progress {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    background: #f8f9fa;
}

.progress {
    height: 8px;
}

.progress-bar {
    background: linear-gradient(90deg, #007bff, #28a745);
}
</style>