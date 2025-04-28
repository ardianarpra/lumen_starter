<?php

namespace App\Http\Controllers;

use App\Models\GawatDarurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GawatDaruratController extends Controller
{
    // Menampilkan semua data mahasiswa
    public function index()
    {
        try {
            $gawatDarurat = GawatDarurat::with('kategoriPenilaian')->get();
            if ($gawatDarurat->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data tersedia.',
                    'data' => []
                ], 404);
            }

            $responseData = $gawatDarurat->map(function ($gawatDarurat) {
                return [
                    'id' => $gawatDarurat->id,
                    'jenis_gawat_darurat' => $gawatDarurat->jenis_gawat_darurat,
                    'nama_pelapor' => $gawatDarurat->nama_pelapor,
                    'telp_pelapor' => $gawatDarurat->telp_pelapor,
                    'latitude' => $gawatDarurat->latitude,
                    'longitude' => $gawatDarurat->longitude,
                    'penilaian' => $gawatDarurat->penilaian,
                    'keterangan_penilaian' => $gawatDarurat->keterangan_penilaian,
                    'kategori_penilaian' => $gawatDarurat->kategoriPenilaian->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'nama_kategori' => $item->nama_kategori,
                        ];
                    }),
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Data gawat darurat berhasil diambil.',
                'data' => $responseData,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // Menambahkan data gawat darurat baru
    public function storeGawatDarurat(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jenis_gawat_darurat' => 'required|string|max:255',
                'nama_pelapor' => 'required|string|max:150',
                'telp_pelapor' => 'required|numeric|digits_between:10,14',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => null
                ], 400);
            }


            $gawatDarurat = GawatDarurat::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Gawat Darurat berhasil ditambahkan.',
                'data' => $gawatDarurat
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // Menambahkan data penilaian gawat darurat baru
    public function storeGawatDaruratPenilaian($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'penilaian' => 'required|in:1,2,3',
                'keterangan_penilaian' => 'string|max:255',
                'kategori_penilaian_id' => 'array',
                'kategori_penilaian_id.*' => 'integer|exists:gd_kategori_penilaian,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => null
                ], 400);
            }

            $gawatDarurat = GawatDarurat::findOrFail($id);

            // Update field penilaian dan keterangan_penilaian
            $gawatDarurat->update([
                'penilaian' => $request->penilaian,
                'keterangan_penilaian' => $request->keterangan_penilaian
            ]);

            // Simpan ke pivot kategori penilaian
            $gawatDarurat->kategoriPenilaian()->sync($request->kategori_penilaian_id);
            $gawatDarurat = GawatDarurat::with('kategoriPenilaian')->find($id);
            $kategoriPenilaian = $gawatDarurat->kategoriPenilaian->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kategori' => $item->nama_kategori,
                ];
            });
            // Gabungkan gawatDarurat dengan kategori_penilaian
            $responseData = $gawatDarurat->toArray();
            $responseData['kategori_penilaian'] = $kategoriPenilaian;

            return response()->json([
                'status' => true,
                'message' => 'Penilaian Gawat Darurat berhasil ditambahkan.',
                'data' => $responseData
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // Menampilkan data Gawat Darurat berdasarkan ID
    public function readGawatDaruratById($id)
    {
        try {
            $gawatDarurat = GawatDarurat::with('kategoriPenilaian')->find($id);
            if (!$gawatDarurat) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data gawat darurat.",
                    'data' => null
                ], 404);
            }
            $kategoriPenilaian = $gawatDarurat->kategoriPenilaian->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kategori' => $item->nama_kategori,
                ];
            });
            // Gabungkan gawatDarurat dengan kategori_penilaian
            $responseData = $gawatDarurat->toArray();
            $responseData['kategori_penilaian'] = $kategoriPenilaian;

            return response()->json([
                'status' => true,
                'message' => 'Data gawat darurat ditemukan',
                'data' => $responseData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    // // Mengupdate data mahasiswa berdasarkan ID
    // public function update(Request $request, $id)
    // {
    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'nama' => 'required|string|max:255',
    //         'nim' => 'required|numeric|unique:table_mahasiswa,nim,' . $id,
    //         'jurusan' => 'required|string|max:255',
    //         'alamat' => 'required|string|max:255',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first(),
    //             'data' => null
    //         ], 400);
    //     }

    //     try {
    //         $mahasiswa = Mahasiswa::find($id);
    //         if (!$mahasiswa) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => "Tidak ditemukan data mahasiswa.",
    //                 'data' => null
    //             ], 404);
    //         }

    //         $mahasiswa->update($request->all());

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data mahasiswa berhasil diperbarui.',
    //             'data' => $mahasiswa
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage(),
    //             'data' => null
    //         ]);
    //     }
    // }

    // Menghapus data Gawat Darurat berdasarkan ID
    public function deleteGawatDarurat($id)
    {
        try {
            $gawatDarurat = GawatDarurat::with('kategoriPenilaian')->find($id);
            if (!$gawatDarurat) {
                return response()->json([
                    'status' => false,
                    'message' => "Tidak ditemukan data Gawat Darurat.",
                    'data' => null
                ], 404);
            }

            $gawatDarurat->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data gawat darurat berhasil dihapus.',
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
