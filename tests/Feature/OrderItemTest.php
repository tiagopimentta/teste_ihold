<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderItemTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_response_200_in_orders(): void
    {
        $response = $this->get('/api/orders/1/items');

        $response->assertStatus(200);
    }
}
