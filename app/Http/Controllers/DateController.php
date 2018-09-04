<?php

namespace App\Http\Controllers;

use App\Date;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Cancel;

class DateController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $fecha = new Carbon($request->fecha);
        if ($request->rol === 'paciente') {
            return response()->json(DB::table('dates')->join('hours', 'dates.id_hora', '=', 'hours.id')->join('medics', 'dates.id_medico', '=', 'medics.id')->select('dates.fecha', 'medics.nombre as medico', 'hours.nombre as hora', 'medics.foto', 'dates.id')->where('fecha', '>=', $fecha)->where('estado', 3)->where('dates.id_paciente', $request->id)->get(), 200);
        } else if ($request->rol === 'medico') {
            return response()->json(DB::table('dates')->join('hours', 'dates.id_hora', '=', 'hours.id')->join('medics', 'dates.id_medico', '=', 'medics.id')->join('patients', 'patients.id', '=', 'dates.id_paciente')->join('states', 'states.id', '=', 'dates.estado')->select('dates.fecha', 'patients.nombre as paciente', 'hours.nombre as hora', 'patients.foto', 'dates.id', 'states.nombre as estado')->where('fecha', '>=', $fecha)->where('estado', 3)->where('dates.id_medico', $request->id)->get(), 200);
        }
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
            'id_medico' => 'required|integer',
            'id_paciente' => 'required|integer',
            'id_hora' => 'required|integer',
            'fecha' => 'required|date'
                ], [
            'id_medico.required' => 'El campo es requerido',
            'id_medico.integer' => 'El campo debe tener un formato valido',
            'id_paciente.required' => 'El campo es requerido',
            'id_paciente.integer' => 'El campo debe tener un formato valido',
            'id_hora.required' => 'El campo es requerido',
            'id_hora.integer' => 'El campo debe tener un formato valido',
            'fecha.required' => 'El campo es requerido',
            'fecha.date' => 'El campo debe tener un formato valido',
        ]);
        try {
            $date = new Date();
            $date->id_medico = $request->id_medico;
            $date->id_paciente = $request->id_paciente;
            $date->id_hora = $request->id_hora;
            $fecha = new Carbon($request->fecha);
            $date->fecha = $fecha;
            $date->estado = 3;
            $date->saveOrFail();
            return response()->json(['message' => 'Agregado correctamente'], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function show(Date $date) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function edit(Date $date) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Date $date) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function destroy(Date $date) {
        //
    }

    public function upd(Request $request) {
        try {
            $date = Date::where('id', $request->id)->firstOrFail();

            if ($request->estado === 'finalizado') {
                $date->estado = 2;
            } else if ($request->estado === 'cancelado') {
                $date->estado = 1;
                $cancel = New Cancel();
                $cancel->id_cita = $request->id;
                $cancel->observacion = $request->observacion;
                $cancel->saveOrFail();
            }
            $date->saveOrFail();
            return response()->json(['message' => $request->estado . ' Correctamente']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

}
