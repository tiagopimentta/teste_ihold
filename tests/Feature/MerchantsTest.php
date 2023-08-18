<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Merchants;

class MerchantsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_response_200_in_merchants_post(): void
    {
        $response = $this->post('api/merchants');
        $response->assertStatus(200);
     
    }
    public function test_response_200_in_todos_merchants_get(): void
    {
        $response = $this->getJson('api/merchants');
        $response->assertStatus(200);
        $merchants = Merchants::all();
         response()->json($merchants);
      
    }
    public function test_response_200_in_unico_merchants_get(): void
    {
        $response = $this->get('api/merchants/1');
        $merchants = Merchants::find(1);
        $response->assertStatus(200);
        response()->json($merchants);
    }
    public function test_response_200_in_alterar_merchants_put(): void
    {
        $response = $this->put('api/merchants/1');
        $response->assertStatus(200);
    }
    public function test_response_200_in_delete_merchants_delete(): void
    {
        $response = $this->delete('api/merchants/1');
        $response->assertStatus(200);
       
    }
}