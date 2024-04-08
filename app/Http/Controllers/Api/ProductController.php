<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //all product
        $products = Product::orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $product = Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category' => $request->category,
            'image' => $filename,
            'is_best_seller' => $request->is_best_seller
        ]);

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Failed to Save',
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product details',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $product->image = $filename;
        }

        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $request->category;
        $product->is_best_seller = $request->is_best_seller;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
