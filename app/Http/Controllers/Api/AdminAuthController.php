<?php

// namespace App\Http\Controllers\Api\V1;
namespace App\Http\Controllers\Api; // Pastikan foldernya sesuais

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if (!$user->is_admin) {
                    Auth::logout();
                    return response()->json(['message' => 'Akses ditolak. Anda bukan admin.'], 403);
                }

                // createToken membutuhkan trait HasApiTokens di Model User
                $token = $user->createToken('admin_token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'token' => $token,
                    'user' => $user
                ]);
            }

            return response()->json(['message' => 'Email atau password salah.'], 401);
        } catch (\Exception $e) {
            // Ini akan memunculkan pesan error asli jika terjadi crash
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi Logout Admin
     */
    public function logout(Request $request)
    {
        try {
            // Menghapus token yang saat ini digunakan oleh user/admin
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil logout, token telah dihapus.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal logout: ' . $e->getMessage()
            ], 500);
        }
    }
}
