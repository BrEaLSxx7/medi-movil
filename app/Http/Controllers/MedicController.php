<?php

namespace App\Http\Controllers;

use App\Medic;
use Illuminate\Http\Request;
use App\Authentication;
use Illuminate\Support\Facades\Hash;

class MedicController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $request->validate(
                    [
                'nombre' => 'required|string|max:100',
                'foto' => 'required|image',
                'tipo_id' => 'required|integer',
                'numero_documento' => 'required|string|max:30',
                'telefono' => 'required|integer|max:90000000000',
                'correo' => 'required|email',
                'precio' => 'required|float',
                'descripcion' => 'required|string|max:143'
                    ], [
                'nombre.required' => 'El campo nombre es requerido',
                'nombre.string' => 'El campo debe estar en un formato válido',
                'nombre.max' => 'El campo tiene demasiados carácxteres',
                'foto.required' => 'El campo escudo es requerido',
                'foto.image' => 'El campo debe tener un formato válido',
                'tipo_id.required' => 'El campo Tipo documento es requerido',
                'tipo_id.integer' => 'El Campo Debe estar en un formato valido',
                'numero_documento.required' => 'El campo Numero documento es requerido',
                'numero_documento.string' => 'El campo debe estar en un formato válido',
                'numero_documento.max' => 'El campo tiene demasiados carácteres',
                'telefono.required' => 'El campo telefono es requerido',
                'telefono.string' => 'El campo debe estar en un formato válido',
                'telefono.max' => 'El campo tiene demasiados carácteres',
                'correo.required' => 'El campo correo es requerido',
                'correo.email' => 'El campo debe estar en un formato válido',
                'precio.required' => 'El campo correo es requerido',
                'precio.float' => 'El campo debe estar en un formato válido',
                'descripcion.required' => 'El campo nombre es requerido',
                'descripcion.string' => 'El campo debe estar en un formato válido',
                'descripcion.max' => 'El campo tiene demasiados carácteres'
            ]);

            if ($request->hasFile('foto')) {
                $medic = new Medic();
                $nameImagen = time() . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('./../files/', $nameImagen);
                $medic->nombre = $request->nombre;
                $medic->tipo_documento_id = $request->tipo_id;
                $medic->numero_documento = $request->numero_documento;
                $medic->telefono = $request->telefono;
                $medic->correo = $request->correo;
                $medic->foto = $nameImagen;
                $medic->precio = $request->precio;
                $medic->descripcion = $request->descripcion;
                $medic->calificacion = 0;
                $medic->saveOrFail();
                $auth = new Authentication();
                $auth->usuario = $request->usuario;
                $auth->contrasena = Hash::make($request->contrasena);
                $auth->id_medico = $medic->id;
                $auth->id_rol = 1;
                $auth->saveOrFail();
                return response()->json(['message' => 'Agregado correctamente'], 201);
            } else {
                return response()->json(['Message' => 'Falta la foto'], 401);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json(['Message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function show(Medic $medic) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function edit(Medic $medic) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medic $medic) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medic $medic) {
        //
    }

}
