<div class="developer-profile">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-cog me-2"></i>Mon Profil Développeur</h2>
        <button class="btn btn-primary" wire:click="edit">
            <i class="fas fa-edit me-2"></i>Modifier le profil
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card profile-card">
                <div class="card-body text-center">
                    @if($developer->avatar)
                        <img src="{{ Storage::url($developer->avatar) }}" alt="Avatar" class="avatar-large mb-3">
                    @else
                        <div class="avatar-placeholder mb-3">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                    @endif
                    
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $developer->title }}</p>
                    <span class="badge bg-{{ $this->getExperienceLevelColor($developer->experience_level) }} mb-3">
                        {{ $developer->experience_level }}
                    </span>
                    
                    <!-- Rating -->
                    <div class="rating mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $developer->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ms-2 text-muted">({{ $developer->rating }}/5)</span>
                    </div>

                    <!-- Social Links -->
                    <div class="social-links">
                        @if($developer->github_url)
                            <a href="{{ $developer->github_url }}" target="_blank" class="btn btn-outline-dark btn-sm me-2">
                                <i class="fab fa-github"></i> GitHub
                            </a>
                        @endif
                        @if($developer->linkedin_url)
                            <a href="{{ $developer->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        @endif
                        @if($developer->portfolio_url)
                            <a href="{{ $developer->portfolio_url }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-globe"></i> Portfolio
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations du profil</h5>
                </div>
                <div class="card-body">
                    <!-- Bio -->
                    <div class="mb-4">
                        <h6>Biographie</h6>
                        <p class="text-muted">{{ $developer->bio ?: 'Aucune biographie disponible.' }}</p>
                    </div>

                    <!-- Skills -->
                    <div class="mb-4">
                        <h6>Compétences</h6>
                        <div class="skills-container">
                            @if($developer->skills)
                                @foreach($this->getSkillsArrayProperty() as $skill)
                                    <span class="skill-tag">{{ trim($skill) }}</span>
                                @endforeach
                            @else
                                <p class="text-muted">Aucune compétence renseignée.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-primary">{{ $developer->active_tasks }}</div>
                                <div class="stat-label">Tâches actives</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-success">{{ $developer->completed_projects }}</div>
                                <div class="stat-label">Projets terminés</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-info">{{ $developer->hours_logged }}h</div>
                                <div class="stat-label">Heures travaillées</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier le profil</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Titre</label>
                                    <input type="text" class="form-control" wire:model="title">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Niveau d'expérience</label>
                                    <select class="form-select" wire:model="experience_level">
                                        <option value="Junior">Junior</option>
                                        <option value="Mid-Level">Mid-Level</option>
                                        <option value="Senior">Senior</option>
                                        <option value="Lead">Lead</option>
                                    </select>
                                    @error('experience_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Compétences (séparées par des virgules)</label>
                                <textarea class="form-control" rows="3" wire:model="skills"></textarea>
                                @error('skills') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Biographie</label>
                                <textarea class="form-control" rows="4" wire:model="bio"></textarea>
                                @error('bio') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">GitHub URL</label>
                                    <input type="url" class="form-control" wire:model="github_url">
                                    @error('github_url') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" wire:model="linkedin_url">
                                    @error('linkedin_url') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Portfolio URL</label>
                                    <input type="url" class="form-control" wire:model="portfolio_url">
                                    @error('portfolio_url') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Avatar</label>
                                <input type="file" class="form-control" wire:model="avatar" accept="image/*">
                                @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
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
.profile-card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: #6c757d;
    border: 4px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.skill-tag {
    display: inline-block;
    background: #e9ecef;
    color: #495057;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.85rem;
    margin: 2px;
}

.skills-container {
    min-height: 40px;
}

.stat-item {
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 10px;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
}

.social-links {
    margin-top: 15px;
}

.rating {
    font-size: 1.1rem;
}
</style>