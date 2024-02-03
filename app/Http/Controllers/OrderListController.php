<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Events\OrderListEvent;
use Illuminate\Support\Facades\Session;

class OrderListController extends Controller
{
    //-------------- Get Order ---------------\\
    public function OrderList()
    {
        $newOrderList = Session::get('OrderList');
        return response()->json(['OrderList' => $newOrderList]);
    }

    public function OrderListShow()
    {
        $settings = Setting::where('deleted_at', '=', null)->first();
        return view('sales.OrderList', [
            'settings' => $settings
        ]);
    }

    public function completeOrder(Request $request)
    {
        $productId = $request->order_id;
        $OrderList = Session::get('OrderList');

        if (isset($OrderList[$productId]) && $OrderList[$productId]['quantity'] > 0) {
            // Reduce the quantity
            $OrderList[$productId]['quantity'] -= 1;

            // Remove the product if the quantity becomes zero
            if ($OrderList[$productId]['quantity'] == 0) {
                unset($OrderList[$productId]);
            }

            // Update the session
            Session::put('OrderList', $OrderList);

            // Broadcast the event
            event(new OrderListEvent($OrderList));

            return response()->json(['OrderList' => $OrderList]);
        }

        return response()->json(['error' => 'Order not found']);
    }

    public function undoOrder(Request $request)
    {
        $productId = $request->order_id;
        $OrderList = Session::get('OrderList');
        $originalQuantity = Session::get('originalQuantity_' . $productId);

        if ($originalQuantity !== null && isset($OrderList[$productId]) && $OrderList[$productId]['quantity'] < $originalQuantity) {
            // Increase the quantity
            $OrderList[$productId]['quantity'] += 1;

            // Update the session
            Session::put('OrderList', $OrderList);

            // Broadcast the event
            event(new OrderListEvent($OrderList));

            return response()->json(['OrderList' => $OrderList]);
        } else {
            return response()->json(['error' => 'Invalid undo operation']);
        }
    }
}
