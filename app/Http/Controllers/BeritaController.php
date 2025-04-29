<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\BeritaLikes;
use App\Models\GawatDarurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    // Menampilkan semua data berita
    public function index()
    {
        try {
            $berita = Berita::all();
            if ($berita->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data tersedia.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berita berhasil diambil.',
                'data' => $berita,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // Menambahkan data berita baru
    public function storeBerita(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'thumbnail' => 'string',
                'berita' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => null
                ], 400);
            }

            $berita = Berita::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Berita berhasil ditambahkan.',
                'data' => $berita
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // Menambahkan like berita
    public function storeLikeBerita($beritaId, $userId)
    {
        try {
            $existingLike = BeritaLikes::where('berita_id', $beritaId)
                ->where('user_id', $userId)
                ->first();
            if ($existingLike) {
                // Jika sudah ada, hapus like
                $existingLike->delete();
                $berita = Berita::find($beritaId);
                if (!$berita) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Berita tidak ditemukan',
                    ], 404);
                }
                $berita->decrement('total_likes');

                return response()->json([
                    'status' => true,
                    'message' => 'Like dihapus.',
                ]);
            } else {
                // Jika belum ada, tambah like
                BeritaLikes::create([
                    'berita_id' => $beritaId,
                    'user_id' => $userId,
                ]);

                $berita = Berita::find($beritaId);
                if (!$berita) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Berita tidak ditemukan',
                    ], 404);
                }
                $berita->increment('total_likes');

                return response()->json([
                    'status' => true,
                    'message' => 'Like ditambahkan.',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // Menampilkan data berita berdasarkan ID
    public function readBeritaById($id)
    {
        try {
            $berita = Berita::find($id);
            if (!$berita) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data berita.",
                    'data' => null
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data berita ditemukan',
                'data' => $berita
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
    public function updateBerita(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'thumbnail' => 'string',
            'berita' => 'required|string',
            'total_likes' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => null
            ], 400);
        }

        try {
            $berita = Berita::find($id);
            if (!$berita) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data berita.",
                    'data' => null
                ], 404);
            }

            $berita->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berita berhasil diperbarui.',
                'data' => $berita
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // Menghapus data berita berdasarkan ID
    public function deleteBerita($id)
    {
        try {
            $berita = Berita::find($id);
            if (!$berita) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data berita.",
                    'data' => null
                ], 404);
            }

            $berita->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berita berhasil dihapus.',
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
