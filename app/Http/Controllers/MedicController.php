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
        return response()->json(Medic::all(), 200);
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
                'telefono' => 'required|integer',
                'correo' => 'required|email',
                'precio' => 'required|between:0,499999.99',
                'descripcion' => 'required|string|max:143',
                'usuario' => 'required|string|unique:authentications',
                'contrasena' => 'required|string'
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
                'telefono.integer' => 'El campo debe estar en un formato válido',
                'correo.required' => 'El campo correo es requerido',
                'correo.email' => 'El campo debe estar en un formato válido',
                'precio.required' => 'El campo correo es requerido',
                'precio.between' => 'El campo debe estar en un formato válido',
                'descripcion.required' => 'El campo nombre es requerido',
                'descripcion.string' => 'El campo debe estar en un formato válido',
                'descripcion.max' => 'El campo tiene demasiados carácteres',
                'usuario.required' => 'El campo nombre es requerido',
                'usuario.string' => 'El campo debe estar en un formato válido',
                'usuario.unique' => 'El usuario ya se encuentra registrado',
                'contrasena.required' => 'El campo nombre es requerido',
                'contrasena.string' => 'El campo debe estar en un formato válido',
            ]);

            if ($request->hasFile('foto')) {
                $medic = new Medic();
                $nameImagen = time() . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('./../files/', $nameImagen);
                $medic->nombre = $request->nombre;
                $medic->tipo_documento = $request->tipo_id;
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
    
    public function img(Request $request) {
        try {
            if ($request->hasFile('foto')){
                $medic= Medic::where('id',$request->id)->firstOrFail();
                $nameImagen= time().$request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('./../files/',$nameImagen);
                $medic->foto=$nameImagen;
                $medic->saveOrFail();
                return response()->json(['message' => 'Actualizado correctamente', 'datos' => $medic], 200);
            } else {
                return response()->json(['message' => 'El campo foto es requerido'], 400);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
    public function upd(Request $request) {
        $request->validate([
            'correo' => 'required|email',
            'telefono' => 'required|integer|max:9999999999',
            'descripcion' => 'required|string|max:143',
            'precio' => 'required|between:0,499999.99'
                ], [
            'telefono.required' => 'El campo Telefono es requerido',
            'telefono.integer' => 'El Campo Debe estar en un formato valido',
            'correo.required' => 'El campo correo es requerido',
            'correo.email' => 'El campo debe estar en un formato válido',
            'precio.required' => 'El campo precio es requerido',
            'precio.between' => 'El campo debe estar en un formato válido',
            'descripcion.required' => 'El campo descripcion es requerido',
            'descripcion.string' => 'El campo debe estar en un formato válido',
            'descripcion.max' => 'El campo tiene demasiados carácteres',
        ]);
        try {
            $medic= Medic::where('id',$request->id)->firstOrFail();
            $medic->telefono = $request->telefono;
            $medic->correo = $request->correo;
            $medic->precio = $request->precio;
            $medic->descripcion = $request->descripcion;
            $medic->saveOrFail();
            return response()->json(['message' => 'Actualizado correctamente', 'datos' => $medic], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
