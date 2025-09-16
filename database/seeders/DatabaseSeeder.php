<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@devcollab.com',
            'role' => 'admin',
            'password' => Hash::make('password123')
        ]);

        // Create test developer user
        $developer = User::create([
            'name' => 'John Doe',
            'email' => 'developer@devcollab.com',
            'role' => 'developer',
            'password' => Hash::make('password123')
        ]);

        // Create developer profile
        Developer::create([
            'user_id' => $developer->id,
            'title' => 'Full Stack Developer',
            'experience_level' => 'Senior',
            'skills' => 'PHP, Laravel, JavaScript, React, Vue.js, MySQL, Docker, Git',
            'bio' => 'Experienced full-stack developer with 5+ years of experience building scalable web applications. Passionate about clean code and modern development practices.',
            'rating' => 4.8,
            'active_tasks' => 5,
            'completed_projects' => 12,
            'hours_logged' => 160,
            
        ]);

        // Create test regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@devcollab.com',
            'role' => 'user',
            'password' => Hash::make('password123')
        ]);

        // Create additional developer for testing
        $dev2 = User::create([
            'name' => 'Sarah Chen',
            'email' => 'sarah@devcollab.com',
            'role' => 'developer',
            'password' => Hash::make('password123')
        ]);

        Developer::create([
            'user_id' => $dev2->id,
            'title' => 'Frontend Developer',
            'experience_level' => 'Mid-Level',
            'skills' => 'JavaScript, React, Vue.js, CSS, SASS, Bootstrap, Tailwind',
            'bio' => 'Frontend specialist with a passion for creating beautiful and intuitive user interfaces.',
            'rating' => 4.5,
            'active_tasks' => 3,
            'completed_projects' => 8,
            'hours_logged' => 120,
           
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
