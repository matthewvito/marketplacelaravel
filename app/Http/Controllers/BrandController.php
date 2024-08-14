<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    
    public function index(Request $request)
    {
        $query = $request->input('keyword');
        $brand = Brand::Where('name', 'LIKE', "%$query%")
        ->orWhere('description', 'LIKE', "%$query%")
        ->orderBy('name', 'asc')
        ->paginate($perPage = 10, $columns = ['*'], $pageName = 'page');
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diambil',
            'data' => $brand

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string|max:255',
            'logo' => 'required|string|max:2048',
            'website' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ], [
            'name.required' => 'Nama brand harus diisi',
            'name.unique' => 'Nama brand sudah digunakan',
            'description.required' => 'Deskripsi brand harus diisi',
            'logo.required' => 'Logo brand harus diisi',
            'website.required' => 'Website brand harus diisi',
            'email.required' => 'Email brand harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        try {
            $brand = Brand::create($validateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
                'data' => $brand
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal ditambahkan. ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return response()->json([
                'status' => 'success',
                'brand' => $brand
            ]);
        }else {
        return response()->json([
            'status' => 'error',
            'message' => 'Data tidak ditemukan',
        ]);
    };
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $validateData = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string|max:255',
                'logo' => 'required|string|max:2048',
                'website' => 'required|string|max:255',
                'email' => 'required|string|max:255',
            ], [
                'name.required' => 'Nama brand harus diisi',
            'description.required' => 'Deskripsi brand harus diisi',
            'logo.required' => 'Logo brand harus diisi',
            'website.required' => 'Website brand harus diisi',
            'email.required' => 'Email brand harus diisi',
            ]);
            $brand->update($validateData);
            if($brand){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil diubah',
                    'data' => $brand
                ]);
            }else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal diubah',
                ]);
            }
         }
    }
   
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }
}
