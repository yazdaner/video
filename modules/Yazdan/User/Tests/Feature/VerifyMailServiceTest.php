<?php

use Tests\TestCase;
use Yazdan\User\Models\User;
use Yazdan\User\Services\VerifyMailService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyMailServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_code()
    {
        $code = VerifyMailService::generateCode();

        $this->assertIsNumeric($code,'assertIsNumeric Error');
        $this->assertLessThanOrEqual(999999,$code,'assertLessThanOrEqual Error');
        $this->assertGreaterThanOrEqual(100000,$code,'assertGreaterThanOrEqual Error');
    }

    public function test_verify_code_can_store()
    {
        $user = User::factory()->create();
        $code = VerifyMailService::generateCode();
        VerifyMailService::cacheSet($user->id,$code);
        $this->assertEquals($code,VerifyMailService::cacheGet($user->id));
    }

}
