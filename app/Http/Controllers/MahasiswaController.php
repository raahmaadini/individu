<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(){
        $category = "Sepatu";
        $products = ['tas', 'hp', 'jam'];
        $testing = "halo ini tes variabel";
        return view('product.list', compact('category', 'products'));
    }
    public function detail($id){
        return "halaman mahasiswa:" .$id;
    }
}
