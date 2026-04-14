<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * READ: Menampilkan semua data user
     */
    public function index()
    {
        // Mengambil semua user (bisa diganti dengan paginate(10) jika data sudah banyak)
        $users = User::all();

        return response()->json([
            'success' => true,
            'message' => 'Data semua user berhasil diambil',
            'data' => $users
        ], 200);
    }

    /**
     * CREATE: Menambahkan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            // Password WAJIB di-hash sebelum masuk ke database
            'password' => Hash::make($request->password),
            // Default ke 0 (bukan admin) jika tidak dikirimkan
            'is_admin' => $request->is_admin ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    /**
     * READ: Menampilkan detail satu user berdasarkan ID
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    /**
     * UPDATE: Memperbarui data user
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // Validasi data. Menggunakan 'sometimes' agar validasi hanya berjalan jika field tersebut dikirim.
        // Rule::unique()->ignore() penting agar email/username milik user ini tidak dianggap duplikat saat update.
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:8',
            'is_admin' => 'sometimes|boolean'
        ]);

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('username')) $user->username = $request->username;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('is_admin')) $user->is_admin = $request->is_admin;

        // Jika password ikut diupdate, pastikan di-hash ulang
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diperbarui',
            'data' => $user
        ], 200);
    }

    /**
     * DELETE: Menghapus user
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ], 200);
    }
}
