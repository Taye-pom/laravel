<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login_a_developer_and_redirect_to_developer_dashboard()
    {
        // Arrange: Create a user with the 'developer' role
        $user = User::factory()->create([
            'role' => 'developer',
            'password' => bcrypt('password'),
        ]);

        // Act & Assert: Test the Livewire component
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('developer.dashboard'));

        // Assert: The user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_shows_an_error_message_with_invalid_credentials()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        // Act & Assert: Test the Livewire component with a wrong password
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors(['email' => __('auth.failed')]);

        // Assert: The user is not authenticated
        $this->assertGuest();
    }
}
