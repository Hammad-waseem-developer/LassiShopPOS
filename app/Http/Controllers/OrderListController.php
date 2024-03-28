<?php

namespace App\Http\Controllers;

use App\Events\OrderList;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Events\OrderListEvent;
use Illuminate\Support\Facades\Session;

class OrderListController extends Controller
{
    //-------------- Get Order ---------------\\
    public function OrderList()
    {
        $orders = Order::get();
        // $newOrderList = Session::get('OrderList');
        // return response()->json(['OrderList' => $newOrderList, 'orders' => $orders]);
        return response()->json(['orders' => $orders]);
    }

    public function OrderListShow()
    {
        $orders = Order::get();
        event(new OrderList($orders));
        $settings = Setting::where('deleted_at', '=', null)->first();
        return view('sales.OrderList', [
            'settings' => $settings
        ]);
    }


    public function completedOrder($orderId,$productId)
    {
        $OrderList = Order::where('new_product_id' , $productId)->where('id' , $orderId)->first();
        // dd($OrderList);
        if($OrderList->quantity > 0)
        {
            $OrderList->quantity -= 1;
            $OrderList->save();
            return response()->json(['OrderList' => $OrderList]);
        }
        else{
            $OrderList->delete();
            return response()->json(['OrderList' => $OrderList]);
        }
        return response()->json(['error' => 'Order not found']);
    }
    public function undoOrder($orderId,$productId)
    {
        $OrderList = Order::where('new_product_id' , $productId)->where('id' , $orderId)->first();
        // dd($OrderList);

        if($OrderList->quantity < $OrderList->orignal_quantity)
        {
            $OrderList->quantity += 1;
            $OrderList->save();
            return response()->json(['OrderList' => $OrderList]);
        }
        else{
            // $OrderList->delete();
            return response()->json(['OrderList' => $OrderList]);
        }
        return response()->json(['error' => 'Order not found']);
    }

//     public function completeOrder(Request $request)
//     {
//         $productId = $request->order_id;
// // Session::forget('OrderList');
//         $OrderList = Session::get('OrderList');
//         dd($OrderList);

//         if (isset ($OrderList[$productId]) && $OrderList[$productId]['quantity'] > 0) {
//             // Reduce the quantity
//             $OrderList[$productId]['quantity'] -= 1;

//             // Remove the product if the quantity becomes zero
//             if ($OrderList[$productId]['quantity'] == 0) {
//                 unset($OrderList[$productId]);
//             }

//             // Update the session
//             Session::put('OrderList', $OrderList);

//             // Broadcast the event
//             event(new OrderListEvent($OrderList));

//             return response()->json(['OrderList' => $OrderList]);
//         }

//         return response()->json(['error' => 'Order not found']);
//     }

//     public function undoOrder(Request $request)
//     {
//         $productId = $request->order_id;
//         $OrderList = Session::get('OrderList');
//         $originalQuantity = Session::get('originalQuantity_' . $productId);

//         if ($originalQuantity !== null && isset ($OrderList[$productId]) && $OrderList[$productId]['quantity'] < $originalQuantity) {
//             // Increase the quantity
//             $OrderList[$productId]['quantity'] += 1;

//             // Update the session
//             Session::put('OrderList', $OrderList);

//             // Broadcast the event
//             event(new OrderListEvent($OrderList));

//             return response()->json(['OrderList' => $OrderList]);
//         } else {
//             return response()->json(['error' => 'Invalid undo operation']);
//         }
//     }
}
