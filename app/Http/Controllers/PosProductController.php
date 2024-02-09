<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\NewProduct;
use Illuminate\Http\Request;
use App\Models\UserWarehouse;
use Illuminate\Validation\Rule;
use App\Models\NewProductDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PosProductController extends Controller
{
    public function index()
    {
        return view('pos-product.index');
    }

    public function getPosProducts()
    {
        $products = NewProduct::with('category')->get();
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
            'name' => 'required|max:255|unique:new_products',
            'category' => 'required',
            'warehouse' => 'required',
            'price' => 'required|min:1',
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
}
