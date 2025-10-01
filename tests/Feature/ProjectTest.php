<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ProjectTest extends TestCase
{
    use RefreshDatabase;    
    //   Test that a project can be created successfully by a manager.  
    public function test_manager_can_create_project()
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);
        $this->actingAs($manager);
        $response = $this->post(route('project_manager.store'), [
            'name'        => 'Test Project',
            'priority'    => 'high',
            'description' => 'This is a test project.',
            'start_date'  => now()->toDateString(),
            'end_date'    => now()->addDays(10)->toDateString(),
            'budget'      => 1000,
        ]);
        $response->assertRedirect(route('project_manager.dashboard'))
                 ->assertSessionHas('success', 'Project created successfully!');

        $this->assertDatabaseHas('projects', [
            'name'     => 'Test Project',
            'priority' => 'high',
            'manager_id' => $manager->id,
        ]);
    }  
    //   Test validation error when required fields are missing.    
    public function test_project_creation_requires_name_and_priority()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $this->actingAs($manager);
        $response = $this->post(route('project_manager.store'), [
            'name' => '', // Missing name
            'priority' => '', // Missing priority
        ]);
        $response->assertSessionHasErrors(['name', 'priority']);
    } 
    //   Test that project is linked to users (developers).
    public function test_project_can_attach_developers()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $developer = User::factory()->create(['role' => 'developer']);
        $this->actingAs($manager);
        $response = $this->post(route('project_manager.store'), [
            'name'        => 'Project with Devs',
            'priority'    => 'medium',
            'users'       => [$developer->id],
        ]);
        $project = Project::first();
        $this->assertTrue($project->users->contains($developer));
    }
}
test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
