<?php

namespace Yazdan\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Yazdan\User\App\Models\User;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_reset_password_request_form()
    {
        $response =$this->get(route('password.request'));
        $response->assertOk();
    }

    public function test_user_can_send_verify_code_reset_password()
    {
        $user = User::factory()->create();
        $response = $this->call('get',route('password.sendVerifyCode'),['email' => $user->email]);
        $response->assertOk()
        ->assertViewIs('User::front.passwords.verifyResetPassword')
        ->assertViewHas('email' , $user->email);
    }


    public function test_user_cant_send_verify_code_reset_password()
    {
        $user = User::factory()->make();
        $response = $this->call('get',route('password.sendVerifyCode'),['email' => $user->email]);
        $response->assertStatus(302);

    }

    public function test_user_banned_after_6_attempt_to_reset_password()
    {
        $user = User::factory()->create();
        for ($i=0; $i < 5; $i++) {
            $this->post(route('password.checkVerifyCode'),['verify_code','email' => $user->email])
            ->assertStatus(302);
        }
        $this->post(route('password.checkVerifyCode'),['verify_code','email' => $user->email])
        ->assertStatus(429);
    }
}
