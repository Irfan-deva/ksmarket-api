<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Products::all());
    }
    public function store(Request $request)
    {
        $fields = $request->validate([
            'thumbnail' => 'required|image|mimes:png,jpg',
            'product_name' => 'required|string',
            'product_description' => 'required|string',
            'product_price' => 'required|string',
            'product_category' => 'required|string',
            'product_name' => 'required|string',
        ]);

        $file = $fields['thumbnail'];
        $file_name = $file->store('/public/uploads/thumbnails');
        return response([
            'thumbnail' => $file_name
        ]);
    }
}
