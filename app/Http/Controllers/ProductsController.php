<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\Products;
use App\Http\Requests\ProductsRequest;
use Exception;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {
        //Validar los datos
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');

        try {
            //Crear un nuevo registro
            $products = new Products();
            $products->name = $name;
            $products->description = $description;
            $products->price = $price;
            $products->save();
            return response()->json([
                'status' => true,
                'message' => 'Producto agregado exitosamente'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no pudo ser agregado'
            ],400);
        }
    }

    public function show(string $id)
    {
        try {
            $products = Products::findOrFail($id);
            return response()->json([
                'status' => true,
                'data' => $products
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no pudo ser encontrado'
            ],404);
        }
    }

    public function update(ProductsRequest $request, string $id)
    {
        //Validar los datos
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');

        try {
            //Encontrar el producto para actualizar
            $products = Products::findOrFail($id);
            $products->name = $name;
            $products->description = $description;
            $products->price = $price;
            $products->save();
            return response()->json([
                'status' => true,
                'message' => 'Producto actualizado exitosamente'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no pudo ser encontrado'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $products = Products::findOrFail($id);
            $products->delete();
            return response()->json([
                'status' => true,
                'message' => 'Producto eliminado exitosamente'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no pudo ser encontrado'
            ],404);
        }
    }
}
