<?php

namespace App\Http\Controllers;

use App\Models\NewProduct;
use App\Models\NewProductDetail;
use App\Models\product_warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddToCartController extends Controller
{
    // session()->forget('cart');

    // public function add_to_cart(Request $request)
    // {
    //     $cart = Session::get('cart') ?? [];
    //     $newProductId = $request->id;

    //     // Initialize an empty array for $totalQuantities
    //     $totalQuantities = [];

    //     // Check if $cart is not null before iterating through it
    //     if ($cart) {
    //         // Calculate total quantity for each product in the cart
    //         foreach ($cart as $cartItem) {
    //             $cartProductDetails = NewProductDetail::where('new_product_id', $cartItem['id'])->get();
    //             foreach ($cartProductDetails as $productDetail) {
    //                 $cartProductWarehouse = product_warehouse::where('product_id', $productDetail->base_product_id)
    //                     ->where('warehouse_id', $request->warehouse_id)
    //                     ->first();

    //                 $inv_qty = $cartProductWarehouse->qte;
    //                 $pos_qty = $productDetail->qty / 1000;
    //                 $sub_qty = $inv_qty - $pos_qty;

    //                 $totalQuantities[$cartItem['id']] = ($totalQuantities[$cartItem['id']] ?? 0) + $sub_qty * $cartItem['quantity'];
    //             }
    //         }
    //     }

    //     // Continue with the rest of your code...
    //     // Track whether any product quantity exceeds available stock
    //     $anyProductOutOfStock = false;

    //     $productDetails = NewProductDetail::where('new_product_id', $newProductId)->get();

    //     foreach ($productDetails as $productDetail) {
    //         $productWarehouse = product_warehouse::where('product_id', $productDetail->base_product_id)
    //             ->where('warehouse_id', $request->warehouse_id)
    //             ->first();

    //         $inv_qty = $productWarehouse->qte;
    //         $pos_qty = $productDetail->qty / 1000;
    //         $sub_qty = $inv_qty - $pos_qty;

    //         // Check total quantity in the cart for this product
    //         $totalQuantityInCart = $totalQuantities[$newProductId] ?? 0;

    //         // Check if adding the current product will exceed the available quantity
    //         if (($totalQuantityInCart + 1) * $pos_qty > $productWarehouse->qte) {
    //             $anyProductOutOfStock = true;
    //             break;
    //         }
    //     }

    //     // Check if any product is out of stock
    //     if ($anyProductOutOfStock) {
    //         return response()->json(
    //             [
    //                 'message' => 'Out of stock',
    //             ],
    //             200
    //         );
    //     } else {
    //         $productId = $newProductId;
    //         $productPrice = $request->price;
    //         $productName = $request->name;
    //         $productImgPath = $request->img_path;

    //         // Check if the product is already in the cart
    //         if (array_key_exists($productId, $cart)) {
    //             $cart[$productId]['quantity'] += 1;
    //         } else {
    //             // Add the product to the cart
    //             $cart[$productId] = [
    //                 'id' => $productId,
    //                 'name' => $productName,
    //                 'price' => $productPrice,
    //                 'img_path' => $productImgPath,
    //                 'quantity' => 1,
    //             ];
    //         }

    //         Session::put('cart', $cart);

    //         return response()->json(
    //             [
    //                 'cart' => $cart,
    //             ]
    //         );
    //     }
    // }

    public function add_to_cart(Request $request)
    {
        dd($request->all());
        $cart = Session::get('cart');
        $productDetails = NewProductDetail::where('new_product_id', $request->id)->get();

        // Track whether any product quantity exceeds available stock
        $anyProductOutOfStock = false;

        foreach ($productDetails as $productDetail) {
            $productWarehouse = product_warehouse::where('product_id', $productDetail->base_product_id)
                ->where('warehouse_id', $request->warehouse_id)
                ->first();

            $inv_qty = $productWarehouse->qte;
            $pos_qty = $productDetail->qty / 1000;
            $sub_qty = $inv_qty - $pos_qty;

            // Adjust $sub_qty based on the quantity already in the cart
            if ($cart != null && array_key_exists($request->id, $cart)) {
                $sub_qty *= $cart[$request->id]['quantity'];
            }

            // Check if adjusted quantity is greater than available stock
            if ($sub_qty >= $productWarehouse->qte) {
                $anyProductOutOfStock = true;
                break; // Exit the loop if any product is out of stock
            }
        }

        // Check if any product is out of stock
        if ($anyProductOutOfStock) {
            return response()->json(
                [
                    'message' => 'Out of stock',
                ],
                200
            );
        } else {

            $cart = Session::get('cart');
            if ($cart == null) {
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
