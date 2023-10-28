<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        #return response()->json(Product::with('category')->get());
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.category_name')->get();
        return response([
            'data' => $products
        ]);
    }

    public function get_products_by_category_id($category_id)
    {
        return  $products = DB::table('products')->where('category_id', $category_id)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'products.product_description',
                'products.product_price',
                'products.product_thumbnail',
                'categories.category_name'
            )->get();
    }
    public function store(Request $request)
    {
        $fields = $request->validate([
            'product_thumbnail' => 'required|image|mimes:png,jpg',
            'product_name' => 'required|string',
            'product_description' => 'required|string',
            'product_price' => 'required|string',
            'category_id' => 'required|string',
        ]);

        $file = $fields['product_thumbnail'];
        $file_name = $file->getClientOriginalName();
        $file->move('media/images/products', $file_name);
        #$file_name = $file->store('/uploads/thumbnails');
        #$thumbnail = str_replace("public/uploads/thumbnails/", '', $file_name);

        $product = new Product();
        $product->product_thumbnail = $file_name;
        $product->product_name = $fields['product_name'];
        $product->product_description = $fields['product_description'];
        $product->product_price = $fields['product_price'];
        $product->category_id = $fields['category_id'];
        $product->save();
        return response([
            'msg' => $product
        ]);
    }
}
