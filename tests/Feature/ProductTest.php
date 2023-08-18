<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class ProductTest extends TestCase
{
    const BASE_API = 'api/products/';

    public $idUserLogged;
    public function setUp(): void
    {
        parent::setUp();
        $this->idUserLogged = $this->logginUser();
    }

    public function test_response_200_in_products_post(): void
    {
        $params = [
            'name' => fake()->word(),
            'price'=>10,
            'status'=>'Ativado'

        ];

        $paramsMerchant = [
            'merchant_name' => fake()->word(),
            'admin_id' => $this->idUserLogged
        ];


        $merchant = $this->post('api/merchants', $paramsMerchant);
        $params['merchant_id'] = $merchant->json()['data']['response']['id'];
        $response = $this->post(self::BASE_API, $params);
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_response_200_in_todos_products_get(): void
    {
        $response = $this->getJson(self::BASE_API);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_response_200_in_unico_products_get(): void
    {
        $response = $this->get(self::BASE_API . 1);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_response_200_in_alterar_products_put(): void
    {

        $params = [
            'name' => fake()->word(),
            'price'=>10,
            'status'=>'Ativado'

        ];

        $paramsMerchant = [
            'merchant_name' => fake()->word(),
            'admin_id' => $this->idUserLogged
        ];


        $merchant = $this->put('api/merchants/1', $paramsMerchant);
        $params['merchant_id'] = $merchant->json()['data']['response']['id'];
        $response = $this->post(self::BASE_API, $params);
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_response_200_in_delete_products_delete(): void
    {
        $params = [
            'name' => fake()->word(),
            'price'=>10,
            'status'=>'Ativado'

        ];

        $paramsMerchant = [
            'merchant_name' => fake()->word(),
            'admin_id' => $this->idUserLogged
        ];


        $merchant = $this->delete('api/merchants/1', $paramsMerchant);
        $params['merchant_id'] = $merchant->json()['data']['response']['id'];
        $response = $this->post(self::BASE_API, $params);
        $response->assertStatus(Response::HTTP_CREATED);


    }
}
