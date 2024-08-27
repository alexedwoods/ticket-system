<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationNotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_notification_can_be_sent()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->postJson('/email/verification-notification');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'verification-link-sent',
        ]);
    }

    public function test_verified_user_is_redirected_to_home()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->postJson('/email/verification-notification');

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_guest_cannot_access_email_verification_notification()
    {
        $response = $this->postJson('/email/verification-notification');

        $response->assertStatus(401);
    }
}
