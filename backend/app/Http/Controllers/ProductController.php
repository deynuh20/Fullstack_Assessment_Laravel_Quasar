<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->type;

        if ($type != null) {
            $products = Product::with('children')->where('product_type', $type)->get();
        } else {
            $products = Product::with('children')->whereNull('product_parent_id')->get();
        }
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_parent_id' => 'nullable|exists:products,product_id',
            'product_name' => 'required| string',
            'product_type' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $product = Product::create($request->all());
        return response()->json('New product added!', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'exists:products,product_id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $updated_product = $product->update($request->all());
        
        return response()->json( $updated_product,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json('Product deleted successfully!', 200);
    }
}
