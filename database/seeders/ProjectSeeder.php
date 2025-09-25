<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $admin = User::where('email', 'admin@devcollab.com')->first();
        $developer = User::where('email', 'developer@devcollab.com')->first();
        $sarah = User::where('email', 'sarah@devcollab.com')->first();
        $user = User::where('email', 'user@devcollab.com')->first();

        // Create projects
        $project1 = Project::create([
            'name' => 'E-commerce Platform',
            'description' => 'Développement d\'une plateforme e-commerce complète avec gestion des commandes, paiements et inventaire.',
            'status' => 'active',
            'priority' => 'high',
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(60),
            'manager_id' => $admin->id,
            'created_by' => $admin->id,
            'progress' => 45,
        ]);

        $project2 = Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Application mobile cross-platform pour la gestion des tâches et la collaboration d\'équipe.',
            'status' => 'active',
            'priority' => 'medium',
            'start_date' => now()->subDays(15),
            'end_date' => now()->addDays(45),
            'manager_id' => $admin->id,
            'created_by' => $admin->id,
            'progress' => 20,
        ]);

        $project3 = Project::create([
            'name' => 'API Documentation',
            'description' => 'Création de la documentation complète pour l\'API REST de la plateforme.',
            'status' => 'planned',
            'priority' => 'low',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(30),
            'manager_id' => $admin->id,
            'created_by' => $admin->id,
            'progress' => 0,
        ]);

        // Assign users to projects
        $project1->users()->attach([$developer->id, $sarah->id]);
        $project2->users()->attach([$developer->id, $user->id]);
        $project3->users()->attach([$sarah->id]);

        // Create tasks for project 1
        Task::create([
            'title' => 'Conception de la base de données',
            'description' => 'Créer le schéma de base de données pour les produits, commandes et utilisateurs.',
            'status' => 'completed',
            'priority' => 'high',
            'project_id' => $project1->id,
            'assigned_to' => $developer->id,
            'created_by' => $admin->id,
            'due_date' => now()->subDays(5),
            'estimated_hours' => 8,
            'actual_hours' => 10,
        ]);

        Task::create([
            'title' => 'Interface utilisateur frontend',
            'description' => 'Développer l\'interface utilisateur responsive pour la navigation et l\'affichage des produits.',
            'status' => 'in_progress',
            'priority' => 'high',
            'project_id' => $project1->id,
            'assigned_to' => $sarah->id,
            'created_by' => $admin->id,
            'due_date' => now()->addDays(10),
            'estimated_hours' => 20,
            'actual_hours' => 8,
        ]);

        Task::create([
            'title' => 'Système de paiement',
            'description' => 'Intégrer Stripe pour le traitement des paiements sécurisés.',
            'status' => 'todo',
            'priority' => 'urgent',
            'project_id' => $project1->id,
            'assigned_to' => $developer->id,
            'created_by' => $admin->id,
            'due_date' => now()->addDays(5),
            'estimated_hours' => 15,
        ]);

        // Create tasks for project 2
        Task::create([
            'title' => 'Architecture de l\'application',
            'description' => 'Définir l\'architecture technique et les technologies à utiliser.',
            'status' => 'completed',
            'priority' => 'high',
            'project_id' => $project2->id,
            'assigned_to' => $developer->id,
            'created_by' => $admin->id,
            'due_date' => now()->subDays(3),
            'estimated_hours' => 6,
            'actual_hours' => 6,
        ]);

        Task::create([
            'title' => 'Interface utilisateur mobile',
            'description' => 'Créer les écrans principaux de l\'application mobile.',
            'status' => 'in_progress',
            'priority' => 'medium',
            'project_id' => $project2->id,
            'assigned_to' => $user->id,
            'created_by' => $admin->id,
            'due_date' => now()->addDays(15),
            'estimated_hours' => 25,
            'actual_hours' => 5,
        ]);

        // Create tasks for project 3
        Task::create([
            'title' => 'Documentation API endpoints',
            'description' => 'Documenter tous les endpoints de l\'API avec exemples d\'utilisation.',
            'status' => 'todo',
            'priority' => 'medium',
            'project_id' => $project3->id,
            'assigned_to' => $sarah->id,
            'created_by' => $admin->id,
            'due_date' => now()->addDays(20),
            'estimated_hours' => 12,
        ]);
    }
}
