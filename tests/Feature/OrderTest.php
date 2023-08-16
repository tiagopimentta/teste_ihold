<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_response_200_in_orders(): void
    {
        $response = $this->get('/api/orders');

        $response->assertStatus(200);
    }
}
