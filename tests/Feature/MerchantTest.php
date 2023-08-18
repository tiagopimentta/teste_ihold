<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class MerchantTest extends TestCase
{
    const BASE_API = 'api/merchants/';

    public function setUp(): void
    {
        parent::setUp();
        $this->logginUser();
    }

    public function test_response_200_in_merchants_post(): void
    {
        $params = [
            'merchant_name' => fake()->word(),
            'admin_id' => 1
        ];

        $response = $this->post(self::BASE_API, $params);
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_response_200_in_todos_merchants_get(): void
    {
        $response = $this->getJson(self::BASE_API);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_response_200_in_unico_merchants_get(): void
    {
        $response = $this->get(self::BASE_API . 1);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_response_200_in_alterar_merchants_put(): void
    {

        $params = [
            'merchant_name' => fake()->word(),
            'admin_id' => 1
        ];

        $merchant = $this->post(self::BASE_API, $params)->json();

        $response = $this->put(self::BASE_API . $merchant['data']['response']['id'], [
            'merchant_name' => fake()->word()
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_response_200_in_delete_merchants_delete(): void
    {
        $params = [
            'merchant_name' => fake()->word(),
            'admin_id' => 1
        ];

        $merchant = $this->post(self::BASE_API, $params)->json();

        $response = $this->delete(self::BASE_API . $merchant['data']['response']['id']);
        $response->assertStatus(Response::HTTP_OK);

    }
}
