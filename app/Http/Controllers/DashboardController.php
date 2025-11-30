<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Produk
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $averagePrice = Product::avg('price') ?? 0;
        $maxPrice = Product::max('price') ?? 0;
        
        // Statistik Member (FIX: pastikan count benar)
        $totalMembers = Member::count();
        
        // Ambil member terbaru (max 5, tapi jika ada 1 ya tampil 1)
        $recentMembers = Member::latest()->limit(5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'averagePrice',
            'maxPrice',
            'totalMembers',
            'recentMembers'
        ));
    }
}
