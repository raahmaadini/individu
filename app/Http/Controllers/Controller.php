<?php

namespace App\Http\Controllers;

trait ResponseFormatter {
    public function success($data, $message = 'Success')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
}

abstract class Controller
{
    use ResponseFormatter;  // ← Shared method untuk semua controller
}
