<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderTest extends TestCase
{
    const BASE_API = 'api/orders/';

    public $idUserLogged;

    public function setUp(): void
    {
        parent::setUp();
        $this->idUserLogged = $this->logginUser();
    }

    public function test_response_200_in_order_post(): void
    {
        $params = [
            'user_id' => User::inRandomOrder()->where(['is_admin' => true])->first()->id,
            'status' => 'Pendente'
        ];

        \request()->merge($params);

        $response = $this->post(self::BASE_API, $params);
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_response_200_in_todos_products_get(): void
    {
        $response = $this->get(self::BASE_API);
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
            'user_id' => User::inRandomOrder()->where(['is_admin' => true])->first()->id,
            'status' => 'Pendente'
        ];

        \request()->merge($params);

        $order = $this->post(self::BASE_API, $params);
        $orderId = $order->json()['data']['response']['id'];

        $response = $this->put(self::BASE_API . $orderId, [
            'status' => 'Finalizado'
        ]);


        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_response_200_in_delete_products_delete(): void
    {
        $params = [
            'user_id' => User::inRandomOrder()->where(['is_admin' => true])->first()->id,
            'status' => 'Pendente'
        ];

        \request()->merge($params);

        $response = $this->post(self::BASE_API, $params);
        $order = $response->assertStatus(Response::HTTP_CREATED);

        $id = $order->json()['data']['response']['id'];

        $response = $this->delete(self::BASE_API . $id);
        $response->assertStatus(Response::HTTP_OK);


    }
}
