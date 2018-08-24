<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use App\Authentication;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         try {
            $request->validate(
                    [
                'nombre' => 'required|string|max:100',
                'foto' => 'required|image',
                'tipo_id' => 'required|integer',
                'numero_documento' => 'required|string|max:30',
                'telefono'=> 'required|string|max:30',
                'correo'=> 'required|string|max:50'
                    ], [
                'nombre.required' => 'El campo nombre es requerido',
                'nombre.string' => 'El campo debe estar en un formato válido',
                'nombre.max' => 'El campo tiene demasiados carácteres',
                'foto.required' => 'El campo escudo es requerido',
                'foto.image' => 'El campo debe tener un formato válido',
                'tipo_id.required' => 'El campo Tipo documento es requerido',
                'tipo_id.integer' => 'El Campo Debe estar en un formato valido',
                'numero_documento.required' => 'El campo Numero documento es requerido',
                'numero_documento.string' => 'El campo debe estar en un formato válido',
                'numero_documento.max' => 'El campo tiene demasiados carácteres',
                'telefono.required'=> 'El campo Teléfono es requerido',
                'telefono.string'=>'El campo debe estar en un formato válido',
                'telefono.max'=>'El campo tiene demasiados carácteres',
                'correo.required'=>'El campo correo es requerido ',
                'correo.string'=>'El campo debe esta en un formacto válido',
                'correo.max'=>'El campo tiene demasiados carácteres',
            ]);
             if ($request->hasFile('foto')) {
                $patient = new Patient();
                $nameImagen = time() . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('./../files/', $nameImagen);
                $patient->nombre = $request->nombre;
                $patient->tipo_documento_id = $request->tipo_id;
                $patient->numero_documento = $request->numero_documento;
                $patient->telefono = $request->telefono;
                $patient->correo = $request->correo;
                $patient->foto = $nameImagen;
                $patient->saveOrFail();
                $auth = new Authentication();
                $auth->usuario = $request->usuario;
                $auth->contrasena = Hash::make($request->contrasena);
                $auth->id_paciente = $patient->id;
                $auth->id_rol =2;
                $auth->saveOrFail();
                return response()->json(['message' => 'Agregado correctamente'], 201);
            } else {
                return response()->json(['Message' => 'Falta la foto'], 401);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response(['Message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
