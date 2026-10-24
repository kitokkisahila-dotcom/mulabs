<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_sees_only_their_own_profile_data(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Alice',
            'second_name' => 'Wanjiku',
            'last_name' => 'Mugo',
            'email' => 'alice@example.com',
            'phone' => '0700000001',
        ]);
        $otherUser = User::factory()->create([
            'first_name' => 'Brian',
            'email' => 'brian@example.com',
            'phone' => '0700000002',
        ]);

        $this->actingAs($user)
            ->get(route('profile.index'))
            ->assertOk()
            ->assertSee('Alice Wanjiku Mugo')
            ->assertSee('alice@example.com')
            ->assertDontSee($otherUser->email);
    }

    public function test_user_can_update_only_their_contact_information(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Alice',
            'last_name' => 'Mugo',
            'sex' => 'Female',
            'email' => 'alice@example.com',
            'phone' => '0700000001',
        ]);

        $this->actingAs($user)
            ->post(route('profile.update'), [
                'email' => 'alice.new@example.com',
                'phone' => '0700000003',
                'first_name' => 'Changed',
                'sex' => 'Male',
            ])
            ->assertRedirect(route('profile.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'alice.new@example.com',
            'phone' => '0700000003',
            'first_name' => 'Alice',
            'sex' => 'Female',
        ]);
    }

    public function test_user_can_change_their_own_password(): void
    {
        $user = User::factory()->create(['password' => 'current-password']);

        $this->actingAs($user)
            ->post(route('profile.password.update'), [
                'current_password' => 'current-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('profile.index'));

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }
}
