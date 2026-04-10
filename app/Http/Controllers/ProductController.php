<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::with(['notes', 'characters'])->get());
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Product::with(['notes', 'characters'])->find($id);
        return $product ? response()->json($product) : response()->json(['message' => 'Not Found'], 404);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
