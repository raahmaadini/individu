<?php

namespace App\Http\Controllers;

class MemberController extends Controller
{
    // Halaman member (yang akan pakai AJAX)
    public function index()
    {
        return view('members.index');
    }
}
