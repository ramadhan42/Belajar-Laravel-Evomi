<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Menampilkan semua daftar brand.
     */
    public function index()
    {
        // Mengambil semua brand, bisa ditambahkan with('products') jika ingin meload produknya sekaligus
        $brands = Brand::all();

        return response()->json([
            'status' => 'success',
            'data' => $brands
        ]);
    }

    /**
     * Menyimpan data brand baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $brand = Brand::create([
            'nama' => $request->nama,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Brand berhasil ditambahkan',
            'data' => $brand
        ], 201);
    }

    /**
     * Menampilkan detail satu brand beserta produk-produknya.
     */
    public function show($id)
    {
        // Menggunakan with('products') karena di model Brand ada relasi hasMany ke Product
        $brand = Brand::with('products')->find($id);

        if (!$brand) {
            return response()->json([
                'status' => 'error',
                'message' => 'Brand tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $brand
        ]);
    }

    /**
     * Update data brand.
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'status' => 'error',
                'message' => 'Brand tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $brand->update([
            'nama' => $request->nama,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Brand berhasil diperbarui',
            'data' => $brand
        ]);
    }

    /**
     * Menghapus brand.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'status' => 'error',
                'message' => 'Brand tidak ditemukan'
            ], 404);
        }

        $brand->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand berhasil dihapus'
        ]);
    }
}
