<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // LIST PRODUK
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // FORM TAMBAH PRODUK
    public function create()
    {
        return view('products.create');
    }

    // SIMPAN PRODUK
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'size' => 'required',
            'stock' => 'required|numeric',
            'image' => 'image|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan');
    }

    // FORM EDIT PRODUK
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // UPDATE PRODUK
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'size' => 'required',
            'stock' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $product->image,
        ]);

        return redirect('/products')->with('success', 'Produk berhasil diupdate');
    }

    // HAPUS PRODUK
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('success', 'Produk dihapus');
    }
    public function report()
{
    return Product::all();
}

}

