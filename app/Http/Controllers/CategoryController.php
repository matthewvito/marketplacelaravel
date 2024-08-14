<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
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
