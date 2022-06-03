<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_view_cart()
    {
        $response = $this->get('/cart');

        $response->assertStatus(200);
    }

    public function test_a_user_can_browse_cart()
    {
        
        $response = $this->get('/cart');

        $response->assertSee("Lista carrito");
    }
}
