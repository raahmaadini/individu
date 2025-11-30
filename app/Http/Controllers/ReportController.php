<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ReportController extends Controller
{
    public function products()
    {
        $products = Product::latest()->get();
        return view('reports.products', compact('products'));
    }
}
