<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    // Menampilkan semua data mahasiswa
    public function index()
    {
        try {
            $mahasiswa = Mahasiswa::all();
            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil diambil.',
                'data' => $mahasiswa
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // Menambahkan data mahasiswa baru
    public function store(Request $request)
    {   
        try{
            // Validasi input
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'nim' => 'required|numeric|unique:table_mahasiswa,nim',
                'jurusan' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => null
                ], 400);
            }

       
            $mahasiswa = Mahasiswa::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Mahasiswa berhasil ditambahkan.',
                'data' => $mahasiswa
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ],500);
        }
    }

    // Menampilkan data mahasiswa berdasarkan ID
    public function show($id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);
            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data mahasiswa.",
                    'data' => null
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa ditemukan.',
                'data' => $mahasiswa
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // Mengupdate data mahasiswa berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric|unique:table_mahasiswa,nim,' . $id,
            'jurusan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => null
            ], 400);
        }

        try {
            $mahasiswa = Mahasiswa::find($id);
            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data mahasiswa.",
                    'data' => null
                ], 404);
            }

            $mahasiswa->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil diperbarui.',
                'data' => $mahasiswa
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // Menghapus data mahasiswa berdasarkan ID
    public function destroy($id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);
            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data mahasiswa.",
                    'data' => null
                ], 404);
            }

            $mahasiswa->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil dihapus.',
                'data' => null
            ], 204);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }
}
