<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\NewProduct;
use Illuminate\Http\Request;
use App\Events\OrderListEvent;
use App\Models\NewProductDetail;
use App\Models\product_warehouse;
use Illuminate\Support\Facades\Session;

class AddToCartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        // Retrieve the cart
        $cart = Session::get('cart') ?? [];
        // Keep track of out-of-stock items
        $outOfStockItems = [];
        $canAddToCart = true; // Assume the products can be added until proven otherwise

        // Continue with the rest of the code for processing the requested product
        $productId = $request->id;
        $productPrice = $request->price;
        $productName = $request->name;
        $productImgPath = $request->img_path;

        // Clone the cart to simulate the addition of the new product
        $simulatedCart = $cart;
        // $simulatedOrderList = $OrderList;
        if (array_key_exists($productId, $simulatedCart)) {
            $simulatedCart[$productId]['quantity'] += 1;
        } else {
            $simulatedCart[$productId] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'img_path' => $productImgPath,
                'quantity' => 1,
            ];
        }

        // Calculate the total quantity needed for all products in the simulated cart
        $totalQuantityNeeded = [];
        foreach ($simulatedCart as $item) {
            $productDetails = NewProductDetail::where('new_product_id', $item['id'])->get();
            foreach ($productDetails as $productDetail) {
                $unit = Unit::where('id', $productDetail->unit_id)->first();
                $ingredientWarehouse = product_warehouse::where('product_id', $productDetail->base_product_id)
                    ->where('warehouse_id', $request->warehouse_id)
                    ->first();

                if ($unit && $ingredientWarehouse) {
                    // Calculate quantity in the base unit
                    $quantityInBaseUnit = $productDetail->qty * $item['quantity'];

                    // Check if unit conversion is needed
                    if ($unit->name !== 'Units') {
                        // Apply unit conversion
                        if ($unit->operator === '/' && $unit->operator_value !== 0) {
                            $quantityInBaseUnit /= $unit->operator_value;
                        } elseif ($unit->operator === '*' && $unit->operator_value !== 0) {
                            $quantityInBaseUnit *= $unit->operator_value;
                        } else {
                            throw new \Exception('Invalid conversion for unit: ' . $unit->name);
                        }
                    }

                    // Add the quantity needed for the current item to the total
                    if (!isset($totalQuantityNeeded[$ingredientWarehouse->product_id])) {
                        $totalQuantityNeeded[$ingredientWarehouse->product_id] = 0;
                    }

                    $totalQuantityNeeded[$ingredientWarehouse->product_id] += $quantityInBaseUnit;

                    if ($totalQuantityNeeded[$ingredientWarehouse->product_id] > $ingredientWarehouse->qte) {
                        // Track out-of-stock item
                        $canAddToCart = false;
                        $outOfStockItems[] = "Out of Stock";
                        break; // Stop checking other ingredients if one is out of stock
                    }
                }
            }
        }

        // Check if any out-of-stock items were found
        if (!$canAddToCart) {
            return response()->json(['message' => 'Out of stock for: ' . implode(', ', $outOfStockItems)]);
        }

        // Update the actual cart if the stock check passes
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

        // Update the cart in the session
        Session::put('cart', $cart);

        // Return the updated cart in the response
        return response()->json(['cart' => $cart]);
    }

    public function addToCart2(Request $request)
    {

        $cart = Session::get('cart') ?? [];
        if (array_key_exists($request->id, $cart)) {
            $cart[$request->id]['quantity'] += 1;
            Session::put('cart', $cart);
        } else {
            $cart[$request->id] = [
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'img_path' => $request->img_path,
                'quantity' => 1,
            ];
            Session::put('cart', $cart);
        }

        return response()->json(['cart' => $cart]);
    }


    public function deleteProductFromCart(Request $request)
    {
        $cart = Session::get('cart');
        // $OrderList = Session::get('OrderList');
        $productId = $request->id;
        unset($cart[$productId]);
        // unset($OrderList[$productId]);
        Session::put('cart', $cart);
        // Session::put('OrderList', $OrderList);
        // event(new OrderListEvent($OrderList));
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }

    public function addQty(Request $request)
    {
        // Retrieve the cart
        $cart = Session::get('cart') ?? [];
        // $OrderList = Session::get('OrderList') ?? [];
        // Keep track of out-of-stock items
        $outOfStockItems = [];
        $canAddToCart = false; // Assume the products can be added until proven otherwise

        // Clone the cart to simulate the addition of the new product
        $simulatedCart = $cart;
        // $simulatedOrderList = $OrderList;

        // Calculate the total quantity needed for all products in the simulated cart
        $totalQuantityNeeded = [];
        foreach ($simulatedCart as $item) {
            $productDetails = NewProductDetail::where('new_product_id', $item['id'])->get();
            foreach ($productDetails as $productDetail) {
                $unit = Unit::where('id', $productDetail->unit_id)->first();
                $ingredientWarehouse = product_warehouse::where('product_id', $productDetail->base_product_id)
                    ->where('warehouse_id', $request->warehouse_id)
                    ->first();

                if ($unit && $ingredientWarehouse) {
                    // Calculate quantity in the base unit
                    $quantityInBaseUnit = $productDetail->qty * $item['quantity'];

                    // Check if unit conversion is needed
                    if ($unit->name !== 'Units') {
                        // Apply unit conversion
                        if ($unit->operator === '/' && $unit->operator_value !== 0) {
                            $quantityInBaseUnit /= $unit->operator_value;
                        } elseif ($unit->operator === '*' && $unit->operator_value !== 0) {
                            $quantityInBaseUnit *= $unit->operator_value;
                        } else {
                            throw new \Exception('Invalid conversion for unit: ' . $unit->name);
                        }
                    }

                    // Add the quantity needed for the current item to the total
                    if (!isset($totalQuantityNeeded[$ingredientWarehouse->product_id])) {
                        $totalQuantityNeeded[$ingredientWarehouse->product_id] = 0;
                    }

                    $totalQuantityNeeded[$ingredientWarehouse->product_id] += $quantityInBaseUnit;

                    if ($totalQuantityNeeded[$ingredientWarehouse->product_id] > $ingredientWarehouse->qte) {
                        // Track out-of-stock item
                        $canAddToCart = false;
                        $outOfStockItems[] = "Out of Stock";
                        break; // Stop checking other ingredients if one is out of stock
                    } else {
                        $canAddToCart = true;
                    }
                }
            }
        }

        // Check if any out-of-stock items were found
        if (!$canAddToCart) {
            return response()->json(['message' => 'Out of stock', 'cart' => $cart]);
        }

        $productDetails = NewProductDetail::where('new_product_id', $request->id)->get();
        foreach ($productDetails as $productDetail) {
            $unit = Unit::where('id', $productDetail->unit_id)->first();
            $ingredientWarehouse = product_warehouse::where('product_id', $productDetail->base_product_id)
                ->where('warehouse_id', $request->warehouse_id)
                ->first();

            if ($unit && $ingredientWarehouse) {
                // Calculate quantity in the base unit
                $quantityInBaseUnit = $productDetail->qty;

                // Check if unit conversion is needed
                if ($unit->name !== 'Units') {
                    // Apply unit conversion
                    if ($unit->operator === '/' && $unit->operator_value !== 0) {
                        $quantityInBaseUnit /= $unit->operator_value;
                    } elseif ($unit->operator === '*' && $unit->operator_value !== 0) {
                        $quantityInBaseUnit *= $unit->operator_value;
                    } else {
                        throw new \Exception('Invalid conversion for unit: ' . $unit->name);
                    }
                }

                // Add the quantity needed for the current item to the total
                if (!isset($totalQuantityNeeded[$ingredientWarehouse->product_id])) {
                    $totalQuantityNeeded[$ingredientWarehouse->product_id] = 0;
                }

                $totalQuantityNeeded[$ingredientWarehouse->product_id] += $quantityInBaseUnit;

                if ($totalQuantityNeeded[$ingredientWarehouse->product_id] > $ingredientWarehouse->qte) {
                    // Track out-of-stock item
                    $canAddToCart = false;
                    $outOfStockItems[] = "Out of Stock";
                    return response()->json(['message' => 'Out of stock', 'cart' => $cart]);
                    break; // Stop checking other ingredients if one is out of stock
                } else {
                    $canAddToCart = true;
                }
            }
        }

        if ($canAddToCart === true) {
            $productId = $request->id;
            $cart[$productId]['quantity'] += 1;
            // $OrderList[$productId]['quantity'] += 1;
            Session::put('cart', $cart);
            // Session::put('OrderList', $OrderList);
            // event(new OrderListEvent($OrderList));
        }
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }

    public function removeQty(Request $request)
    {
        $cart = Session::get('cart');
        // $OrderList = Session::get('OrderList');
        $productId = $request->id;
        $cart[$productId]['quantity'] -= 1;
        // $OrderList[$productId]['quantity'] -= 1;
        Session::put('cart', $cart);
        // Session::put('OrderList', $OrderList);
        // event(new OrderListEvent($OrderList));
        return response()->json(
            [
                'cart' => $cart
            ]
        );
    }
}
