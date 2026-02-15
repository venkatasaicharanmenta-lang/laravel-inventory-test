<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $filePath = storage_path('app/products.json');

    $products = json_decode(file_get_contents($filePath), true);

    // Sort by datetime (latest first)
    usort($products, function ($a, $b) {
        return strtotime($b['datetime']) - strtotime($a['datetime']);
    });

    return view('products', compact('products'));
}

    public function store(Request $request)
    {
        $data = [
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'datetime' => now()->toDateTimeString()
        ];

        $filePath = storage_path('app/products.json');

        $existingData = json_decode(file_get_contents($filePath), true);

        $existingData[] = $data;

        file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

        return response()->json(['success' => true]);

    }
}
