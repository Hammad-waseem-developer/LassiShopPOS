<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddToCartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $cart = Session::get('cart');
        if($cart == null){
            $cart = [];
        }
        $productId = $request->id;
        $productPrice = $request->price;
        $productName = $request->name;
        $productImgPath = $request->img_path;


        if (array_key_exists($productId, $cart)) {
            $cart[$productId]['quantity'] += 1;
        } else {

            $cart[$productId] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'img_path' => $productImgPath,
                'quantity' => 1,
            ];
        }
        Session::put('cart', $cart);
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }

    public function deleteProductFromCart(Request $request)
    {
        $cart = Session::get('cart');
        $productId = $request->id;
        unset($cart[$productId]);
        Session::put('cart', $cart);
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }

    public function addQty(Request $request)
    {
        $cart = Session::get('cart');
        $productId = $request->id;
        $cart[$productId]['quantity'] += 1;
        Session::put('cart', $cart);
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }

    public function removeQty(Request $request)
    {
        $cart = Session::get('cart');
        $productId = $request->id;
        $cart[$productId]['quantity'] -= 1;
        Session::put('cart', $cart);
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }
}
