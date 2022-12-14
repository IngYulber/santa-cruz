<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Pago;
use App\Http\Requests\Pago\CreateRequest;
use App\Models\Colaborador;
use App\Models\DetallePago;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas_deudas = DetallePago::join('pago', 'pago.id', '=', 'id_pago')
                                    ->select('pago.*', DB::raw('COUNT(id_pago) as total'))
                                    ->where('detalle_pagos.estado', 0)
                                    ->groupBy('id_pago')
                                    ->orderBy('pago.estado','asc')
                                    ->orderBy('pago.fecha_fin','asc')
                                    ->get();

        $cuentas_deudas2 = DetallePago::join('pago', 'pago.id', '=', 'id_pago')
                                    ->select('pago.*', DB::raw('COUNT(id_pago) as total'))
                                    ->groupBy('id_pago')
                                    ->orderBy('pago.estado','asc')
                                    ->orderBy('pago.fecha_fin','asc')
                                    ->get();

        foreach ($cuentas_deudas as $item) {
            foreach($cuentas_deudas2 as $item2 ){
                if($item["id"] == $item2["id"]){
                    $item2["total2"] = $item["total"];
                    break;
                }
            }
        }

        return JsonResource::collection($cuentas_deudas2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.cobranza');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $pago = Pago::create($request->validated());

        $colaboradores = Colaborador::whereIn('estado',['habilitado','suspendido'])->get();

        foreach ($colaboradores as $user) {
            $detail = new DetallePago();
            $detail->id_colaborador = $user->id;
            $detail->id_pago = $pago->id;
            $detail->estado = False;
            $detail->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('content.cobranza_detail')->with('id', $id);
    }

    public function showDetail($id)
    {
        $detalle = DetallePago::join('colaborador', 'colaborador.id', '=', 'id_colaborador')
            ->join('pago', 'pago.id', '=', 'id_pago')
            ->where('detalle_pagos.id_pago', $id)
            ->select('detalle_pagos.id', 'colaborador.nombre', 'colaborador.apellido', 'pago.monto', 'detalle_pagos.estado', 'detalle_pagos.updated_at')
            ->orderBy('detalle_pagos.estado', 'asc')
            ->get();
        return JsonResource::collection($detalle);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
