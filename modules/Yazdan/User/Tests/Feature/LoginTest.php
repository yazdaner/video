<?php

namespace Yazdan\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Yazdan\User\App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_with_email()
    {
        $this->withoutExceptionHandling();
        $password = 'ASdeafd#2$safe';

        $user = User::factory()->state(['password' => bcrypt($password)])->create()->toArray();

        $response = $this->post(route('login'),[
            'email' => $user['email'],
            'password' => $password
        ]);

        $response->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }

    public function test_user_can_login_with_mobile()
    {
        $password = 'ASdeafd#2$safe';
        $mobile = '9364561235';

       User::factory()->state(['password' => bcrypt($password),'mobile' => $mobile])->create()->toArray();

        $response = $this->post(route('login'),[
            'email' => $mobile,
            'password' => $password
        ]);

        $response->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }
}
