<?php

namespace App\Livewire;

use App\Models\Developer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeveloperProfile extends Component
{
    use WithFileUploads;

    public $showEditModal = false;
    public $developer;
    public $user;

    // Profile fields
    public $title = '';
    public $experience_level = 'Junior';
    public $skills = '';
    public $bio = '';
    public $avatar;
    public $github_url = '';
    public $linkedin_url = '';
    public $portfolio_url = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'experience_level' => 'required|in:Junior,Mid-Level,Senior,Lead',
        'skills' => 'required|string',
        'bio' => 'nullable|string|max:1000',
        'avatar' => 'nullable|image|max:2048',
        'github_url' => 'nullable|url',
        'linkedin_url' => 'nullable|url',
        'portfolio_url' => 'nullable|url',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->developer = $this->user->developer;
        
        if ($this->developer) {
            $this->loadDeveloperData();
        } else {
            // Create developer profile if it doesn't exist
            $this->developer = Developer::create([
                'user_id' => $this->user->id,
                'title' => 'Developer',
                'experience_level' => 'Junior',
                'skills' => '',
                'bio' => '',
                'rating' => 0.0,
                'active_tasks' => 0,
                'completed_projects' => 0,
                'hours_logged' => 0,
            ]);
            $this->loadDeveloperData();
        }
    }

    public function loadDeveloperData()
    {
        $this->title = $this->developer->title ?? '';
        $this->experience_level = $this->developer->experience_level ?? 'Junior';
        $this->skills = $this->developer->skills ?? '';
        $this->bio = $this->developer->bio ?? '';
        $this->github_url = $this->developer->github_url ?? '';
        $this->linkedin_url = $this->developer->linkedin_url ?? '';
        $this->portfolio_url = $this->developer->portfolio_url ?? '';
    }

    public function edit()
    {
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'experience_level' => $this->experience_level,
            'skills' => $this->skills,
            'bio' => $this->bio,
            'github_url' => $this->github_url,
            'linkedin_url' => $this->linkedin_url,
            'portfolio_url' => $this->portfolio_url,
        ];

        // Handle avatar upload
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
            
            // Delete old avatar if exists
            if ($this->developer->avatar) {
                Storage::disk('public')->delete($this->developer->avatar);
            }
        }

        $this->developer->update($data);

        $this->showEditModal = false;
        session()->flash('message', 'Profil mis à jour avec succès !');
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->loadDeveloperData();
    }

    public function getSkillsArrayProperty()
    {
        return $this->developer->getSkillsArrayAttribute();
    }

    public function getExperienceLevelColor($level)
    {
        return match($level) {
            'Junior' => 'success',
            'Mid-Level' => 'primary',
            'Senior' => 'warning',
            'Lead' => 'danger',
            default => 'secondary',
        };
    }

    public function render()
    {
        return view('livewire.developer-profile');
    }
}
