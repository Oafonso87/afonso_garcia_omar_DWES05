<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\DB;



class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = DB::table('pedidos as p')
        ->join('usuarios as u', 'p.usuario_id', '=', 'u.id')
        ->join('productos as pr', 'p.producto_id', '=', 'pr.id')
        ->select(
            'p.id as pedido_id',
            'u.nombre as nombre_usuario',
            'u.apellidos as apellidos_usuario',
            'pr.nombre as nombre_producto',
            'pr.marca as marca_producto',
            'p.cantidad',
            'p.precio_total',
            'p.fecha_pedido'
        )
        ->get();

        if($pedidos->isNotEmpty()){
        $response = new ApiResponse(
            status: 'success',
            code: 200,
            message: 'Estos son todos los pedidos realizados.',
            data: $pedidos
        );
        } else {
            $response = new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al leer los pedidos.',
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
        $pedido = new Pedido;

        $pedido->usuario_id   = $request->input('usuario_id');
        $pedido->producto_id  = $request->input('producto_id');
        $pedido->cantidad     = $request->input('cantidad');
        $pedido->precio_total = $request->input('precio_total');
        $pedido->fecha_pedido = $request->input('fecha_pedido');

        if ($pedido->save()) {
            $response = new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Se ha aniadido un pedido con los siguientes datos:',
                data: $pedido
            );
        } else {
            $response = new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al crear el pedido.',
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
        $pedido = DB::table('pedidos as p')
        ->join('usuarios as u', 'p.usuario_id', '=', 'u.id')
        ->join('productos as pr', 'p.producto_id', '=', 'pr.id')
        ->select(
            'p.id as pedido_id',
            'u.nombre as nombre_usuario',
            'u.apellidos as apellidos_usuario',
            'pr.nombre as nombre_producto',
            'pr.marca as marca_producto',
            'p.cantidad',
            'p.precio_total',
            'p.fecha_pedido'
        )
        ->where('p.id', $id)
        ->first();

        if($pedido){
            $response = new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Este es el pedido con el Id seleccionado:',
                data: $pedido
            );
        } else {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Pedido no encontrado.',
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
        $pedido = Pedido::find($id);

        if (!$pedido) {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Pedido no encontrado.',
                data: null
            );
            return response()->json($response->getResponse(), $response->getCode());
        }

        $validatedData = $request->validate([
            'usuario_id'   => 'sometimes|required|exists:usuarios,id',
            'producto_id'  => 'sometimes|required|exists:productos,id',
            'cantidad'     => 'sometimes|required|integer|min:1',
            'precio_total' => 'sometimes|required|numeric|min:0',
            'fecha_pedido' => 'sometimes|required|date'
        ]);

        $pedido->usuario_id   = $validatedData['usuario_id']   ?? $pedido->usuario_id;
        $pedido->producto_id  = $validatedData['producto_id']  ?? $pedido->producto_id;
        $pedido->cantidad     = $validatedData['cantidad']     ?? $pedido->cantidad;
        $pedido->precio_total = $validatedData['precio_total'] ?? $pedido->precio_total;
        $pedido->fecha_pedido = $validatedData['fecha_pedido'] ?? $pedido->fecha_pedido;

        if ($pedido->save()) {
            $response = new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Pedido actualizado correctamente.',
                data: $pedido
            );
        } else {
            $response = new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al actualizar el pedido, verifique los datos proporcionados.',
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
        $pedido = Pedido::find($id);

        if (!$pedido) {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Pedido no encontrado.',
                data: null
            );
            return response()->json($response->getResponse(), $response->getCode());
        }    
        
        if ($pedido->delete()) {
            $response = new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Pedido eliminado con exito.',
                data: null
            );
        } else {
            $response = new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al eliminar el pedido.',
                data: null
            );            
        }
        return response()->json($response->getResponse(), $response->getCode());
    }
}
