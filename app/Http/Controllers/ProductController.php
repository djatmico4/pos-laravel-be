<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.products.index', compact('products'));
    }
    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product = new Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $request->category;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|min:3|unique:products,name,' . $id,
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);

        $product = Product::findOrFail($id);

        //update detail product
        $product->update([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category' => $request->category,
        ]);

        //update product image if add new image
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products/', $filename);

            //delete old image
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }
            $product->update(['image' => $filename]);
        }

        ///THIS STATEMENT NO WITH CHANGE IMAGE
        // $data = $request->all();
        // $product = Product::findOrFail($id);
        // $product->update($data);
        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {

        // Check if there are any order items associated with this product
        // $orderItemsCount = DB::table('order_items')->where('product_id', $id)->count();

        // if ($orderItemsCount > 0) {
        // return redirect()->route('product.index')->with('error', 'Cannot delete product. There are associated order items.');
        // }

        // Hapus semua order items terkait dengan produk
        DB::table('order_items')->where('product_id', $id)->delete();

        // No associated order items, proceed with product deletion
        // delete product
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');

        // Tandai produk sebagai tidak tersedia
        // $product = Product::findOrFail($id);
        // $product->update(['available' => false]);

        // return redirect()->route('product.index')->with('success', 'Product marked as unavailable');
    }
}
