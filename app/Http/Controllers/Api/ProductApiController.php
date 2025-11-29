<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Product::orderBy('name')->get()
        ]);
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json(['message' => 'created', 'data' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json(['message' => 'updated', 'data' => $product]);
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json(['message' => 'deleted']);
    }
}
