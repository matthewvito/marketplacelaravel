<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use OpenAPI\Attributes as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Dokumentasi API",
 *      description="Gunakan API ini untuk mengelola data produk",
 *      @OA\Contact(
 *          email="matthew080409@gmail.com"
 *      )
 * )
 * 
 * @OA\SecurityScheme(
 *    type="http",
 *    scheme="bearer",
 *    securityScheme="bearerAuth"
 * )
 * 
 * 
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="ProductsAPI"
 * )
 * 
 * 
 * @OA\Schema(
 *     schema="Product",
 *     required={"id", "name", "price", "stock"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Product 1"),
 *     @OA\Property(property="price", type="number", example=10000),
 *     @OA\Property(property="stock", type="integer", example=10),
 * )
 * 
 * 
 * @OA\Schema(
 *     schema="User",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="password", type="string", example="password123"),
 * )
 * @OA\Schema(
 *     schema="Category",
 *     required={"id", "name", "description"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Electronics"),
 *     @OA\Property(property="description", type="string", example="Category for electronic products"),
 * )
 * 
 * @OA\Schema(
 *     schema="Brand",
 *     required={"id", "name", "description", "logo", "website", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Apple"),
 *     @OA\Property(property="description", type="string", example="Innovative technology company"),
 *     @OA\Property(property="logo", type="string", example="https://example.com/apple-logo.png"),
 *     @OA\Property(property="website", type="string", example="https://www.apple.com"),
 *     @OA\Property(property="email", type="string", example="info@apple.com"),
 * )
 * 
 * 
 * 
 */
class ProductControllerAPI extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="products", type="array", @OA\Items(ref="#/components/schemas/Product")),
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $query = $request->input('keyword');
        if($query) {
            $products = Product::where('name', 'LIKE', "%$query%")
        ->orWhere('price', 'LIKE', "%$query%")
        ->orWhere('stock', 'LIKE', "%$query%")
        ->orderBy('price', 'desc');
        
        }else {
            $products = Product::with(['category', 'brand'])->orderBy('price', 'desc');
            
        }
        
        $category = $request->input('category');
        if($category) {
            $products = $products->whereHas('category', function ($query) use ($category) {
                $query->where('name', 'like', "%$category%");
            });
        }

        $brand = $request->input('brand');
        if($brand) {
            $products = $products->whereHas('brand', function ($query) use ($brand) {
                $query->where('name', 'like', "%$brand%");
            });
        }

        $products = $products->paginate(10);

        $products->getCollection()->transform(function ($product) {
            return[
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'category' => $product->category ? $product->category->name : null,
            'brand' => $product->brand ? $product->brand->name : null,
            ];
        });
        
        return response()->json(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */

     /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "price", "stock"},
     *              @OA\Property(property="name", type="string", example="Product 1"),
     *              @OA\Property(property="price", type="number", example=10000),
     *              @OA\Property(property="stock", type="integer", example=10),
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Product created"),
     *              @OA\Property(property="product", ref="#/components/schemas/Product"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'name' => 'required|string|max:50',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
            ],
            [
                'name.required' => 'Please fill the name field',
                'price.required' => 'Please fill the price field',
                'stock.required' => 'Please fill the stock field',
            ]

        );
        $product = Product::create($validateData);
        if ($product) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'product' => $product
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not'
            ]);
        };
    }

    /**
     * Display the specified resource.
     */
  

    /**
     * @OA\Get(
     *    path="/api/products/{id}",
     *   tags={"Product"},
     * security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *     name="id",
     *    in="path",
     *  required=true,
     * description="ID of the product",
     * @OA\Schema(
     *   type="string"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="success",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="product", ref="#/components/schemas/Product"),
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="Product not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Product not found"),
     * )
     * )
     * )
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

     /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *    path="/api/products/{id}",
     *  tags={"Product"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * required=true,
     * description="ID of the product",
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name", "price", "stock"},
     * @OA\Property(property="name", type="string", example="Product 1"),
     * @OA\Property(property="price", type="number", example=10000),
     * @OA\Property(property="stock", type="integer", example=10),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="success",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Product updated"),
     * @OA\Property(property="product", ref="#/components/schemas/Product"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Product not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Product not found"),
     * )
     * )
     * )
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($validateData);
        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

   /**
     * Update the specified resource in storage.
     */
 /**
     * @OA\Delete(
     *   path="/api/products/{id}",
     * tags={"Product"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the product",
     * @OA\Schema(
     * type="string"
     * )
     *  
     * 
     * ),
     * @OA\Response(
     * response=200,
     * description="success",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Product deleted"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Product not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Product not found"),
     * )
     * )
     * )
     */

    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
