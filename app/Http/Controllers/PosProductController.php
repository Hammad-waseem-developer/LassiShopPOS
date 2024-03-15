<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Point;
use App\Models\Client;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\NewProduct;
use Illuminate\Http\Request;
use App\Models\UserWarehouse;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\NewProductDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PosProductController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('pos-product.index', compact('warehouses'));
    }

    public function getPosProducts(Request $request)
    {
        $products = NewProduct::with('category')->where('warehouse_id', $request->id)->with('Product_Deatils')->get();
        return response()->json($products);
    }

    public function create()
    {
        $categories = Category::all();
        $warehouses = Warehouse::all();
        $baseProduct = Product::all();
        $units = Unit::all();
        return view('pos-product.create', compact('categories', 'warehouses', 'baseProduct', 'units'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category' => 'required',
            'warehouse' => 'required',
            'price' => 'required|min:1',
            'online_product_price' => 'required|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredient_id' => 'required',
            'ingredient_id.*' => [
                'required',
                Rule::unique('new_product_details', 'base_product_id')
                    ->where('new_product_id', $request->id)
            ],
            'unit_id.*' => 'required',
            'quantity.*' => 'required',
        ], [
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name cannot exceed 255 characters.',
            'name.unique' => 'The product name must be unique.',
            'category.required' => 'The category field is required.',
            'warehouse.required' => 'The warehouse field is required.',
            'price.required' => 'The price field is required.',
            'price.min' => 'The price must be at least 1.',
            'online_product_price.required' => 'The online product price field is required.',
            'online_product_price.min' => 'The online product price must be at least 1.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be in one of the formats: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image file size must be less than 2048 KB.',
            // Add more custom messages for other fields as needed
        ]);
        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $product = new NewProduct();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->warehouse_id = $request->warehouse;
        $product->price = $request->price;
        $product->online_product_price = $request->online_product_price;
        if ($request->image != null) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->extension();
            $image->move(public_path('/images/products'), $filename);
            $product->img_path = $filename;
        }
        $product->save();

        if ($request->ingredient_id == null) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }
        // Loop through each ingredient
        foreach ($request->ingredient_id as $key => $ingredientId) {
            $productDetail = new NewProductDetail();
            $productDetail->new_product_id = $product->id;
            $productDetail->base_product_id = $ingredientId;
            $productDetail->unit_id = $request->unit_id[$key];
            $productDetail->qty = $request->quantity[$key];
            $productDetail->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Product created successfully']);
    }

    public function edit($id)
    {
        $product = NewProduct::with('Product_Deatils')->find($id);
        $categories = Category::all();
        $warehouses = Warehouse::all();
        $baseProduct = Product::all();
        $units = Unit::all();
        return view('pos-product.edit', compact('product', 'categories', 'warehouses', 'baseProduct', 'units'));
    }

    public function product_ingredients()
    {
        $product = Product::all();
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category' => 'required',
            'warehouse' => 'required',
            'price' => 'required|min:1',
            'online_product_price' => 'required|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'ingredient_id' => 'required',
            'ingredient_id.*' => [
                'required',
            ],
            'unit_id.*' => 'required',
            'quantity.*' => 'required',
        ], [
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name cannot exceed 255 characters.',
            'category.required' => 'The category field is required.',
            'warehouse.required' => 'The warehouse field is required.',
            'price.required' => 'The price field is required.',
            'price.min' => 'The price must be at least 1.',
            'online_product_price.required' => 'The online product price field is required.',
            'online_product_price.min' => 'The online product price must be at least 1.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be in one of the formats: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image file size must be less than 2048 KB.',
            'ingredient_id.required' => 'The ingredients field is required.',
            'unit_id.required' => 'The unit field is required.',
            'quantity.required' => 'The quantity field is required.',
            // Add more custom messages for other fields as needed
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return redirect()->back()->withErrors($validator)->withInput()->with('errors', $errors);
        }

        $product = NewProduct::find($id);
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->warehouse_id = $request->warehouse;
        $product->price = $request->price;
        $product->online_product_price = $request->online_product_price;
        if ($request->new_image != null) {
            $image = $request->file('image');
            // dd($image);
            $filename = time() . '.' . $image->extension();
            $image->move(public_path('/images/products'), $filename);
            $product->img_path = $filename;
            if (File::exists(public_path('/images/products/' . $request->old_image))) {
                unlink(public_path('/images/products/' . $request->old_image));
            }
        } else {
            $product->img_path = $request->old_image;
        }
        $product->save();

        if ($request->ingredient_id == null) {
            $errors = $validator->errors()->all();
            return redirect()->back()->withErrors($validator)->withInput()->with('errors', $errors);
        }

        $productDetails = NewProductDetail::where('new_product_id', $id)->get();
        foreach ($productDetails as $productDetail) {
            $productDetail->delete();
        }
        foreach ($request->ingredient_id as $key => $ingredientId) {
            $productDetail = new NewProductDetail();
            $productDetail->new_product_id = $product->id;
            $productDetail->base_product_id = $ingredientId;
            $productDetail->unit_id = $request->unit_id[$key];
            $productDetail->qty = $request->quantity[$key];
            $productDetail->save();
        }

        // return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
        return redirect()->route('pos-product.index')->with('success', 'Product updated successfully');
    }

    public function delete(Request $request)
    {
        $product = NewProduct::find($request->id);
        // dd($product);
        if ($product->img_path != null) {
            unlink(public_path('/images/products/' . $product->img_path));
        }
        $productDetails = NewProductDetail::where('new_product_id', $request->id)->get();
        foreach ($productDetails as $productDetail) {
            $productDetail->delete();
        }
        $product->delete();
        return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
    }

    public function getNumberOrder()
    {
        $last = DB::table('clients')->latest('id')->first();

        if ($last) {
            $code = $last->code + 1;
        } else {
            $code = 1;
        }
        return $code;
    }

    public function addCustomer( Request $request )
    {
        // dd()
        $user_auth = auth()->user();
        if ($user_auth->can('client_add')) {

            $setting = Setting::where('deleted_at', '=', null)->first();

            $request->validate([
                'username' => 'required',
                'photo'          => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            ]);

            if ($request->hasFile('photo')) {

                $image = $request->file('photo');
                $filename = time() . '.' . $image->extension();
                $image->move(public_path('/images/clients'), $filename);
            } else {
                $filename = 'no_avatar.png';
            }

            $client = Client::create([

                'user_id'        => $user_auth->id,
                'username'       => $request['username'],
                'code'           => $this->getNumberOrder(),
                'email'          => $request['email'],
                'city'           => $request['city'],
                'phone'          => $request['phone'],
                'address'        => $request['address'],
                'status'         => 1,
                'photo'          => $filename,
            ]);

            if ($setting->on_register == 1) {
                Point::create([
                    'user_id' => $client->id,
                    'total_user_point' => $setting->on_register_ponit,
                    'remaining_user_point' => $setting->on_register_ponit,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }else{
                Point::create([
                    'user_id' => $client->id,
                    'total_user_point' => 0,
                    'remaining_user_point' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            return response()->json(['success' => true]);
        }
        return abort('403', __('You are not authorized'));

    }

    public function searchCustomer(Request $request)
    {
        $search = $request->input('keyword');
        $customers = Client::where('username', 'like', '%' . $search . '%')
                           ->orWhere('phone', 'like', '%' . $search . '%')
                           ->get();
        return response()->json($customers);
    }

}
