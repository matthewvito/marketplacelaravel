<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $products = Product::all();
        return view('products.index')->with(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ], [
            'name.required' => 'Nama produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'stock.required' => 'Stok produk harus diisi'
        ]);
        $product = Product::create($validatedData);
      return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

       return view('products.show')->with(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' =>'required',
            'price' =>'required|numeric',
           'stock' =>'required|integer',
        ],[
            'name.required' => 'Please fill the name field',
            'price.required' => 'Please fill the price field',
            'stock.required' => 'Please fill the stock field',
        ]
    
    );
        Product::where('id', $id)->update($validateData);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return redirect()->route('products.index');
    }   
}