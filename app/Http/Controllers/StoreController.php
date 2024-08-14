<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query('keyword');
        $stores = Store::where('name', 'like', "%$query%")
        ->orWhere('address', 'like', "%$query%")
        ->orWhere('phone', 'like', "%$query%")
        ->orderBy('id', 'desc')
        ->paginate($perPage = 10, $columns = ['*'], $pageName = 'page');
        return response()->json([
            'status' => 'success',
            'stores' => $stores
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validateData = $request->validate([
            'name' =>'required|string|max:50',
            'address' =>'required|string|max:30',
            'phone' =>'required|string|max:30',
        ], [
            'name.required' => 'Please fill the name field',
            'address.required' => 'Please fill the address field',
            'phone.required' => 'Please fill the phone field',
        ]);
        $store = Store::create($validateData);
        if($store){
            return response()->json([
                'status' => 'success',
                'message' => 'Store created successfully',
                'store' => $store
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Store not created'
            ]);
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $store = Store::find($id);
        if($store){
            return response()->json([
                'status' => 'success',
                'store' => $store
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validateData = $request->validate([
            'name' =>'required|string',
            'address' =>'required|string',
            'phone' =>'required|string',
        ], [
            'name.required' => 'Please fill the name field',
            'address.required' => 'Please fill the address field',
            'phone.required' => 'Please fill the phone field',
        ]);
        $store = Store::find($id);
        if ($store) {
            $store->update($validateData);
            return response()->json([
                'status' => 'success',
                'message' => 'Store updated successfully',
                'store' => $store
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $store = Store::find($id);
        if ($store) {
            $store->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Store deleted successfully',
                'store' => $store
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found'
            ]);
        }
    }
}
