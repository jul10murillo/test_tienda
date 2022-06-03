<?php

namespace Tests\Feature;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_view_products()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee("Tienda Evertec");
    }

    public function test_a_user_can_browse_posts()
    {
        $product = Product::factory()->create();
        
        $response = $this->get('/');

        $response->assertSee($product->name);
        $response->assertSee($product->price);
    }
}
