<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::beginTransaction();
    }

    public function logginUser()
    {
        $email = fake()->email();
        $password = 123456;

        $user = User::factory()->create(['is_admin' => true, 'password' => $password, 'email' => $email]);

        $response = $this->actingAs($user, 'api')
            ->post('/api/auth/login', [
                'email' => $email,
                'password' => $password,
            ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->json('access_token')
        ]);
    }

    public function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}
