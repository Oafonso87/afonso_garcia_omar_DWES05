<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Utils\ApiResponse;



class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();

        if($usuarios->isNotEmpty()){
        $response = new ApiResponse(
            status: 'success',
            code: 200,
            message: 'Estos son todos los usuarios actualmente.',
            data: $usuarios
        );
        } else {
            $response = new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al leer los usuarios.',
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
        $usuario = new Usuario;

        $usuario->nombre = $request->input('nombre');
        $usuario->apellidos = $request->input('apellidos');
        $usuario->email = $request->input('email');
        $usuario->password = $request->input('password');
        
        if ($usuario->save()) {
            $response = new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Se ha aniadido un usuario con los siguientes datos:',
                data: $usuario
            );     
        } else {
            $response = new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al guardar el usuario.',
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
        $usuario = Usuario::find($id);

        if($usuario){
            $response = new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Este es el usuario con el Id seleccionado:',
                data: $usuario
            );
        } else {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Usuario no encontrado.',
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
        $usuario = Usuario::find($id);

        if (!$usuario) {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Usuario no encontrado.',
                data: null
            );
            return response()->json($response->getResponse(), $response->getCode());
        }

        $validatedData = $request->validate([
            'nombre'   => 'sometimes|required|string|max:100',
            'apellidos'    => 'sometimes|required|string|max:100',
            'email'   => 'sometimes|required|string|max:100',
            'password' => 'sometimes|required|numeric'
        ]);

        $usuario->nombre   = $validatedData['nombre']   ?? $usuario->nombre;
        $usuario->apellidos    = $validatedData['apellidos']    ?? $usuario->apellidos;
        $usuario->email   = $validatedData['email']   ?? $usuario->email;
        $usuario->password = $validatedData['password'] ?? $usuario->password;

        if ($usuario->save()) {
            $response = new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Usuario actualizado correctamente.',
                data: $usuario
            );
        } else {
            $response = new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al actualizar el usuario, verifique los datos proporcionados.',
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
        $usuario = Usuario::find($id);

        if (!$usuario) {
            $response = new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Usuario no encontrado.',
                data: null
            );
            return response()->json($response->getResponse(), $response->getCode());
        }    
        
        if ($usuario->delete()) {
            $response = new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Usuario eliminado con exito.',
                data: null
            );
        } else {
            $response = new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al eliminar el usuario.',
                data: null
            );            
        }
        return response()->json($response->getResponse(), $response->getCode());
    }
}