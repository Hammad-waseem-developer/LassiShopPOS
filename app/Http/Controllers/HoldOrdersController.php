<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\HoldOrder;
use App\Models\HoldProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class HoldOrdersController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'warehouse_id' => 'required',
            'reference_number' => 'required',
            'shipping' => 'required',
            'orderTax' => 'required',
            'discount' => 'required',
            'discountType' => 'required',
            'hold_products.*' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'error',
                'data' => $validator->errors()
            ]);
        }
        $existHold = HoldOrder::where('reference_no', $request->reference_number)->first();
        if ($existHold) {
            $existHold->delete();
        }
        $holdOrder = new HoldOrder();
        $holdOrder->warehouse_id = $request->warehouse_id;
        $holdOrder->reference_no = $request->reference_number;
        $holdOrder->shipping = $request->shipping;
        $holdOrder->orderTax = $request->orderTax;
        $holdOrder->discount = $request->discount;
        $holdOrder->discountType = $request->discountType;
        $holdOrder->created_at = Carbon::now();
        $holdOrder->save();

        $cart = $request->input('hold_products.cart');

        foreach ($cart as $productId => $item) {
            $holdProduct = new HoldProduct();
            $holdProduct->hold_order_id = $holdOrder->id;
            $holdProduct->product_id = $item['id'];
            $holdProduct->name = $item['name'];
            $holdProduct->price = $item['price'];
            $holdProduct->quantity = $item['quantity'];
            $holdProduct->img_path = $item['img_path'];
            $holdProduct->save();
        }
        Session::forget('cart');
        return response()->json([
            'message' => 'success',
            'data' => $holdOrder
        ]);
    }

    public function edit(Request $request)
    {
        $holdOrder = HoldOrder::find($request->id);
        $holdProducts = HoldProduct::where('hold_order_id', $request->id)->get();
        return response()->json([
            'message' => 'success',
            'data' => compact('holdOrder', 'holdProducts'),
        ]);
    }

    public function getHoldList(Request $request)
    {
        $holdList = HoldOrder::with('holdProducts')->get();
        return response()->json($holdList);
    }

    public function delete(Request $request)
    {
        $holdOrder = HoldOrder::find($request->id);
        if ($holdOrder->holdProducts->count() > 0) {
            $holdOrder->holdProducts()->delete();
        }

        $holdOrder->delete();

        return response()->json([
            'message' => 'success',
            'data' => 'Hold order deleted successfully',
        ]);
    }
}
