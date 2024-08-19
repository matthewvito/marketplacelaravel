<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Display a listing of categories",
     *     tags={"Categories"},
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
     *             @OA\Property(property="categories", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = $request->input('keyword');
        $categories = Category::where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->orderBy('name', 'desc')
            ->paginate($perPage = 10, $columns = ['*'], $pageName = 'page');
        return response()->json([
            'status' => 'success',
            'categories' => $categories
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Store a newly created category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","description"},
     *             @OA\Property(property="name", type="string", maxLength=50, example="Category Name"),
     *             @OA\Property(property="description", type="string", maxLength=255, example="Category Description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category created successfully"),
     *             @OA\Property(property="category", type="object")
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
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
        ]);
        $category = Category::create($validateData);
        if ($category) {
            return response () ->json ([
                'status' => 'success',
                'message' => 'Category created successfully',
                'category' => $category
            ]);
            } else {
            return response () ->json ([
                'status' => 'error',
                'message' => 'Category created failed',
            ]);
                
                
            };
         
        

}

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Get a specific category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="category", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                'status' => 'success',
                'category' => $category
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Update a specific category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","description"},
     *             @OA\Property(property="name", type="string", maxLength=50, example="Updated Category Name"),
     *             @OA\Property(property="description", type="string", maxLength=255, example="Updated category description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category updated successfully"),
     *             @OA\Property(property="category", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Category not found")
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
        $category = Category::find($id);
        if ($category) {
            $validateData = $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'required|string|max:255',
            ], [
                'name.required' => 'Name is required',
                'description.required' => 'Description is required',
            ]);
            $category->update($validateData);
            if ($category) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Category updated successfully',
                    'category' => $category
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category updated failed'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Delete a category",
     *     description="Delete a category by its ID",
     *     operationId="deleteCategory",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category to delete",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Category deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ]);
        }
    }
}
