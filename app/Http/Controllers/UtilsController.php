<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UtilsController extends Controller
{
    //

    public function Kpis()
    {
        $por_cuentas_cobrar = DetallePago::where('estado', 0)->count();
        $total_deudas = DetallePago::all()->count();
        $total_monto = DetallePago::join('pago','pago.id','=','id_pago')->where('detalle_pagos.estado', 0)->select('pago.monto')->sum('pago.monto');
        $por_deudas_vencidas = DetallePago::join('pago','pago.id','=','id_pago')->where('detalle_pagos.estado', 0)->where('pago.fecha_fin', '<', Carbon::now())->count();
        $data = [
            "cuentasCobrar" => $por_cuentas_cobrar,
            "totalCobrar" => $total_deudas,
            "montoCobrar" => $total_monto,
            "porDeudasVencidas" => $por_deudas_vencidas
        ];

        return $data;
    }
}
