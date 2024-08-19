<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/brands",
     *     summary="Get list of brands",
     *     tags={"Brands"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Search keyword",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data berhasil diambil"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="first_page_url", type="string"),
     *                 @OA\Property(property="from", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="last_page_url", type="string"),
     *                 @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="next_page_url", type="string"),
     *                 @OA\Property(property="path", type="string"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="prev_page_url", type="string"),
     *                 @OA\Property(property="to", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     )
     * )
     */
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
    /**
     * @OA\Post(
     *     path="/api/brands",
     *     summary="Store a new brand",
     *     tags={"Brands"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","description","logo","website","email"},
     *             @OA\Property(property="name", type="string", example="Brand Name"),
     *             @OA\Property(property="description", type="string", example="Brand Description"),
     *             @OA\Property(property="logo", type="string", example="https://example.com/logo.png"),
     *             @OA\Property(property="website", type="string", example="https://example.com"),
     *             @OA\Property(property="email", type="string", format="email", example="contact@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data gagal ditambahkan.")
     *         )
     *     )
     * )
     */
    /**
     * @OA\Post(
     *     path="/api/brands",
     *     summary="Store a new brand",
     *     tags={"Brands"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","description","logo","website","email"},
     *             @OA\Property(property="name", type="string", example="Brand Name"),
     *             @OA\Property(property="description", type="string", example="Brand Description"),
     *             @OA\Property(property="logo", type="string", example="https://example.com/logo.png"),
     *             @OA\Property(property="website", type="string", example="https://example.com"),
     *             @OA\Property(property="email", type="string", format="email", example="contact@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data berhasil ditambahkan"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data gagal ditambahkan.")
     *         )
     *     )
     * )
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
    /**
 * @OA\Get(
 *     path="/api/brands/{id}",
 *     summary="Get a specific brand",
 *     description="Retrieve details of a specific brand by ID",
 *     operationId="getBrand",
 *     tags={"Brands"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the brand to retrieve",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="brand", type="object", ref="#/components/schemas/Brand")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Brand not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
 *         )
 *     )
 * )
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
    /**
 * @OA\Put(
 *     path="/api/brands/{id}",
 *     summary="Update a specific brand",
 *     description="Update details of a specific brand by ID",
 *     operationId="updateBrand",
 *     tags={"Brands"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the brand to update",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "description", "logo", "website", "email"},
 *             @OA\Property(property="name", type="string", example="Brand Name"),
 *             @OA\Property(property="description", type="string", maxLength=255, example="Brand Description"),
 *             @OA\Property(property="logo", type="string", maxLength=2048, example="https://example.com/logo.png"),
 *             @OA\Property(property="website", type="string", maxLength=255, example="https://example.com"),
 *             @OA\Property(property="email", type="string", maxLength=255, example="contact@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Data berhasil diubah"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Brand")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Brand not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
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
   
    /**
 * @OA\Delete(
 *     path="/api/brands/{id}",
 *     summary="Delete a brand",
 *     description="Delete a brand by its ID",
 *     operationId="deleteBrand",
 *     tags={"Brands"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the brand to delete",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Data berhasil dihapus")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Brand not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
 *         )
 *     )
 * )
 */
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
