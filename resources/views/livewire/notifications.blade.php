<div class="notifications">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-bell me-2"></i>Notifications</h2>
        <div>
            @if($unreadCount > 0)
                <button class="btn btn-primary me-2" wire:click="markAllAsRead">
                    <i class="fas fa-check-double me-2"></i>Marquer tout comme lu
                </button>
            @endif
            <button class="btn btn-outline-secondary" wire:click="toggleShowAll">
                {{ $showAll ? 'Afficher moins' : 'Afficher tout' }}
            </button>
        </div>
    </div>

    <!-- Unread Count -->
    @if($unreadCount > 0)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Vous avez {{ $unreadCount }} notification{{ $unreadCount > 1 ? 's' : '' }} non lue{{ $unreadCount > 1 ? 's' : '' }}
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Notifications List -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                {{ $showAll ? 'Toutes les notifications' : 'Notifications récentes' }}
            </h5>
        </div>
        <div class="card-body p-0">
            @forelse($notifications as $notification)
                <div class="notification-item p-3 border-bottom {{ !$notification->read ? 'bg-light' : '' }}">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon me-3">
                            <i class="{{ $notification->icon }} text-{{ $notification->color }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 {{ !$notification->read ? 'fw-bold' : '' }}">
                                        {{ $notification->title }}
                                    </h6>
                                    <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="notification-actions">
                                    @if(!$notification->read)
                                        <button class="btn btn-sm btn-outline-primary me-2" 
                                                wire:click="markAsRead({{ $notification->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-danger" 
                                            wire:click="delete({{ $notification->id }})"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune notification</h4>
                    <p class="text-muted">Vous n'avez pas encore de notifications.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($showAll && $notifications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<style>
.notification-item {
    transition: background-color 0.2s;
}

.notification-item:hover {
    background-color: #f8f9fa !important;
}

.notification-icon {
    font-size: 1.2rem;
    width: 30px;
    text-align: center;
}

.notification-actions {
    opacity: 0;
    transition: opacity 0.2s;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.notification-item.unread {
    border-left: 4px solid #007bff;
}
</style>