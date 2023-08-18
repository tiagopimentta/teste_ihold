<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Products;

class ProductsTest extends TestCase
{
    /**
     * A basic test example.
     */
         
    public function test_response_200_in_products_post(): void
    {
        $response = $this->post('api/products');

                    // define your $token here
                $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdGVzdGVfaWhvbGQvcHVibGljL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjkyMzI1NjAzLCJleHAiOjE2OTIzMjkyMDMsIm5iZiI6MTY5MjMyNTYwMywianRpIjoiNnVBdlJFdkZEaDBrb2ZRZCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.iVtulmsIMHxp2miUW6qGy18uSlMShn-O5mKts8mp0WY';
                $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                ->json('post', 'api/products');
           $response->assertStatus(200);
           
      
    }
    public function test_response_200_in_todos_products_get(): void
    {
        $response = $this->get('api/products');
        $response->assertStatus(200);
    }
    public function test_response_200_in_unico_products_get(): void
    {
        $response = $this->get('api/products/1');
        $response->assertStatus(200);
      
    }
    public function test_response_200_in_alterar_products_put(): void
    {
        $response = $this->put('api/products/1');
        $response->assertStatus(200);
    }
    public function test_response_200_in_delete_products_delete(): void
    {
        $response = $this->delete('api/products/1');
        $response->assertStatus(200);
    }
     
}
