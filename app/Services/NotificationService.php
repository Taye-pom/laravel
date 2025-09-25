<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;

class NotificationService
{
    public static function create($userId, $type, $title, $message, $data = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function taskAssigned(Task $task, User $user)
    {
        return self::create(
            $user->id,
            'task_assigned',
            'Nouvelle tâche assignée',
            "Une nouvelle tâche '{$task->title}' vous a été assignée dans le projet '{$task->project->name}'.",
            [
                'task_id' => $task->id,
                'project_id' => $task->project_id,
            ]
        );
    }

    public static function taskCompleted(Task $task, User $user)
    {
        return self::create(
            $user->id,
            'task_completed',
            'Tâche terminée',
            "La tâche '{$task->title}' a été marquée comme terminée.",
            [
                'task_id' => $task->id,
                'project_id' => $task->project_id,
            ]
        );
    }

    public static function projectUpdated(Project $project, User $user, $changes = [])
    {
        $changeText = implode(', ', $changes);
        return self::create(
            $user->id,
            'project_updated',
            'Projet mis à jour',
            "Le projet '{$project->name}' a été mis à jour : {$changeText}.",
            [
                'project_id' => $project->id,
            ]
        );
    }

    public static function timeEntryCreated($userId, $projectName, $duration)
    {
        return self::create(
            $userId,
            'time_entry_created',
            'Temps enregistré',
            "Vous avez enregistré {$duration} de travail sur le projet '{$projectName}'.",
            [
                'project_name' => $projectName,
                'duration' => $duration,
            ]
        );
    }

    public static function userMentioned(User $mentionedUser, User $mentioner, $context, $contextId)
    {
        return self::create(
            $mentionedUser->id,
            'user_mentioned',
            'Vous avez été mentionné',
            "{$mentioner->name} vous a mentionné dans {$context}.",
            [
                'mentioner_id' => $mentioner->id,
                'context' => $context,
                'context_id' => $contextId,
            ]
        );
    }

    public static function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('read', false)
            ->count();
    }

    public static function getRecentNotifications($userId, $limit = 10)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function markAllAsRead($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now(),
            ]);
    }
}
