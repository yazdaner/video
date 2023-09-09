<?php

namespace Yazdan\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Yazdan\User\App\Models\User;
use Yazdan\User\Services\VerifyMailService;

class registerationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_register_form()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }
    public function test_user_can_register()
    {
        $user = User::factory()->make()->toArray();
        $user['password'] = 'snajfri$AA90234@203';
        $user['mobile'] = '9364561235';

        $response = $this->post(route('register'),[
            'name' => $user['name'],
            'email' => $user['email'],
            'mobile' => $user['mobile'],
            'password' => $user['password'],
            'password_confirmation' => $user['password']
        ]);

        $response->assertRedirect(route('home'));
        $this->assertCount(1,User::all());
    }

    public function test_user_have_to_verify_account()
    {
        $user = User::factory()->unverified()->create();
        $response = $this->actingAs($user)
        ->get(route('home'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_user_can_verify_account()
    {
        $user = User::factory()->unverified()->create();
        auth()->loginUsingId($user->id);
        $this->assertAuthenticated();

        $code = VerifyMailService::generateCode();
        VerifyMailService::cacheSet($user->id,$code,120);

        $this->post(route('verification.verify'),[
            'verify_code' => $code
        ]);

       $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_verified_user_can_see_home_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
        ->get(route('home'));

        $this->assertAuthenticated();
        $response->assertOK();
    }
}
