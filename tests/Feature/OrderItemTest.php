<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderItemTest extends TestCase
{
    const BASE_API = 'api/orders/';

    public function setUp(): void
    {
        parent::setUp();
        $this->logginUser();
    }
    /**
     * A basic test example.
     */
    public function test_response_200_in_orders(): void
    {
        $response = $this->get(self::BASE_API . '1/items');
        $response->assertStatus(200);
    }
}
