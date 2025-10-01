<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
class AuthTest extends TestCase
{
    use RefreshDatabase;
    //  @test
    public function user_can_register_successfully()
    {
        $response = $this->post('/register', [
            'name' => 'John Bliss',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'developer',
        ]);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role'  => 'developer',
        ]);
    }
    //  @test
    public function user_cannot_register_with_existing_email()
    {
        User::factory()->create(['email' => 'john@example.com']);
        $response = $this->post('/register', [
            'name' => 'John Duplicate',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'user',
        ]);
        $response->assertSessionHasErrors('email');
    }
    //  @test
    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => Hash::make('secret123'),
        ]);
        $response = $this->post('/login', [
            'email' => 'jane@example.com',
            'password' => 'secret123',
        ]);
        $response->assertRedirect(); // Redirects based on role
        $this->assertAuthenticatedAs($user);
    }
    //  @test
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'mark@example.com',
            'password' => Hash::make('secret123'),
        ]);
        $response = $this->from('/login')->post('/login', [
            'email' => 'mark@example.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
    //  @test
    public function user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
test('example', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});
