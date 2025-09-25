<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    use WithPagination;

    public $showAll = false;

    public function render()
    {
        $query = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if (!$this->showAll) {
            $query->limit(10);
        } else {
            $notifications = $query->paginate(15);
        }

        if (!$this->showAll) {
            $notifications = $query->get();
        }

        $unreadCount = NotificationService::getUnreadCount(Auth::id());

        return view('livewire.notifications', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        session()->flash('message', 'Notification marquée comme lue');
    }

    public function markAllAsRead()
    {
        NotificationService::markAllAsRead(Auth::id());
        session()->flash('message', 'Toutes les notifications ont été marquées comme lues');
    }

    public function delete(Notification $notification)
    {
        $notification->delete();
        session()->flash('message', 'Notification supprimée');
    }

    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
    }
}
