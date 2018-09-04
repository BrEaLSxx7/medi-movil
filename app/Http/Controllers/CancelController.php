<?php

namespace App\Http\Controllers;

use App\Cancel;
use Illuminate\Http\Request;
use App\Date;

class CancelController extends Controller {

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
        $request->validate([
            'id_cita' => 'required|integer',
            'observacion' => 'required|string|max:143'
                ], [
            'id_cita.required' => 'El campo es requerido',
            'observacion.required' => 'El campo es requerido',
            'id_cita.integer' => 'El campo debe tener un formato valido',
            'observacion.string' => 'El campo debe tener un formato valido',
            'observacion.max' => 'El campo debe tiene demasiados caracteres'
            ]);
            try {
                $date=Date::where('id',$request->id_cita)->firstOrFail();
                $date->estado=1;
                $date->saveOrFail();
                $cancel=new Cancel();
                $cancel->id_cita=$request->id_cita;
                $cancel->observacion=$request->observacion;
                $cancel->saveOrFail();
                return response()->json(['message'=>'Cancelado correctamente'],201);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
                return response()->json(['message'=>$ex->getMessage()],500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function show(Cancel $cancel) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function edit(Cancel $cancel) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cancel $cancel) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cancel $cancel) {
        //
    }
}
