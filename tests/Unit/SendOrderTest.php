<?php

namespace Tests\Unit;

use App\Helpers;
use App\Models\Product;
use Tests\TestCase;


class SendOrderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_send_order()
    {
        $product = Product::find(1);

        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => "1",
            'price' => $product->price,
            'attributes' => array(
                'image' => $product->thumbnail,
            )
        ]);
        
        $input = [
            'firstName'=>'Test',
            'lastName'=>'Test',
            'email'=>'test@info.com',
            'document'=>'102223322',
            'mobile'=>'3005115504'
        ];

        $response = Helpers::sendOrder($input);   

        $data = json_decode($response);        
        
        $this->assertEquals($data->status->status,'OK');

    }
}
