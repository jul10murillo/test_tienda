<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class CartController extends Controller
{
    public function cartList()
    {
        if(isset($_COOKIE["requestId"]))
        {
            $orderId = $_COOKIE['order'];
            $order = Orders::find($orderId);
            $status = Helpers::getOrder($_COOKIE["requestId"]);
            if($status == "APPROVED"){
                $order->status = Orders::STATUS_PAYED;
                Session::flash('message', 'Pago aprobado'); 
                Session::flash('alert-class', 'alert-success');

            }elseif ($status == "PENDING") {
                $order->status = Orders::STATUS_CREATED;
                Session::flash('message', 'Pago pendiente'); 
                Session::flash('alert-class', 'alert-info');
            }elseif ($status == "REJECTED") {
                $order->status = Orders::STATUS_REJECTED;
                Session::flash('message', 'Pago rechazado'); 
                Session::flash('alert-class', 'alert-error');
            }
            setcookie("requestId", "", time()-3600);
            setcookie("order", "", time()-3600);
            $order->save();
            \Cart::clear();
        }

        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return view('cart', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');

        return redirect()->route('cart.list');
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.list');
    }

    public function sendCart(Request $request)
    {
        

        $input = $request->all();

        if($input['paymentMethod'] == "placetopay"){
            $order = new Orders();
            $order->customer_name = $input['firstName'].' '.$input['lastName'];
            $order->customer_email = $input['email'];
            $order->customer_mobile = $input['mobile'];
            $order->status = Orders::STATUS_CREATED;
            $order->save();

            setcookie("order", $order->id, time()+3600); 
            $response = Helpers::sendOrder($input);
            Helpers::setLocation($response);
            return redirect()->route('cart.list');
        }
        Session::flash('message', 'Método de pago inhabilitado'); 
        Session::flash('alert-class', 'alert-warning');
        return redirect()->route('cart.list');
    }

}