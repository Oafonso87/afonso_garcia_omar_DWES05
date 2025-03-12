<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Utils\ApiResponse;



class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();

        if($productos->isNotEmpty()){
        $response = new ApiResponse(
            status: 'success',
            code: 200,
            message: 'Estos son todos los productos disponibles.',
            data: $productos
        );
        } else {
            $response = new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al leer los productos.',
                data: null
            );
        }
    
        return response()->json($response->getResponse(), $response->getCode());         
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $producto = new Producto;

        $producto->nombre = $request->input('nombre');
        $producto->marca = $request->input('marca');
        $producto->precio = $request->input('precio');
        $producto->unidades = $request->input('unidades');
        
        if ($producto->save()) {
            $response = new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Se ha aniadido un producto con los siguientes datos:',
                data: $producto
            );     
        } else {
            $response = new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al crear el producto.',
                data: null
            );     
        }
        return response()->json($response->getResponse(), $response->getCode());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);

        if($producto){
            $response = new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Este es el producto con el Id seleccionado:',
                data: $producto
            );
        } else {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Producto no encontrado.',
                data: null
            );
        }        
        return response()->json($response->getResponse(), $response->getCode());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Producto no encontrado.',
                data: null
            );
            return response()->json($response->getResponse(), $response->getCode());
        }

        $validatedData = $request->validate([
            'nombre'   => 'sometimes|required|string|max:100',
            'marca'    => 'sometimes|required|string|max:50',
            'precio'   => 'sometimes|required|numeric',
            'unidades' => 'sometimes|required|integer|min:0'
        ]);

        $producto->nombre   = $validatedData['nombre']   ?? $producto->nombre;
        $producto->marca    = $validatedData['marca']    ?? $producto->marca;
        $producto->precio   = $validatedData['precio']   ?? $producto->precio;
        $producto->unidades = $validatedData['unidades'] ?? $producto->unidades;

        if ($producto->save()) {
            $response = new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Producto actualizado correctamente.',
                data: $producto
            );
        } else {
            $response = new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al actualizar el producto, verifique los datos proporcionados.',
                data: null
            );        
        }
        return response()->json($response->getResponse(), $response->getCode());    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Producto no encontrado.',
                data: null
            );
            return response()->json($response->getResponse(), $response->getCode());
        }    
        
        if ($producto->delete()) {
            $response = new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Producto eliminado con exito.',
                data: null
            );
        } else {
            $response = new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al eliminar el producto.',
                data: null
            );            
        }
        return response()->json($response->getResponse(), $response->getCode());
    }
}
