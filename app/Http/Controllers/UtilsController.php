<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UtilsController extends Controller
{
    //

    public function Kpis()
    {
        $por_cuentas_cobrar = DetallePago::where('estado', 0)->count();
        $total_deudas = DetallePago::all()->count();
        $total_monto = DetallePago::join('pago', 'pago.id', '=', 'id_pago')->where('detalle_pagos.estado', 0)->select('pago.monto')->sum('pago.monto');
        $por_deudas_vencidas = DetallePago::join('pago', 'pago.id', '=', 'id_pago')->where('detalle_pagos.estado', 0)->where('pago.fecha_fin', '<', Carbon::now())->count();

        $cuentas_deudas = DetallePago::join('pago', 'pago.id', '=', 'id_pago')->select('pago.descripcion', DB::raw('COUNT(id_pago) as total'))
            ->where('detalle_pagos.estado', 0)
            ->where('pago.estado', 'Deudas pendientes')
            ->groupBy('id_pago')
            ->orderBy('pago.fecha_fin', 'asc')
            ->take(10)
            ->get();

        $data = [
            "cuentasCobrar" => $por_cuentas_cobrar,
            "totalCobrar" => $total_deudas,
            "montoCobrar" => $total_monto,
            "porDeudasVencidas" => $por_deudas_vencidas,
            "cuentas_deudas" => $cuentas_deudas
        ];

        return $data;
    }


    public function reportesView()
    {
        return view('content.reportes');
    }

    public function generarReporte(Request $request)
    {
        $tipo_reporte = $request->reporte;

        $respuesta = "";

        switch ($tipo_reporte) {
            case 'Total por deudas pendientes':
                $respuesta = $this->reporteTotalDeudasPendiente($request);
                break;
            case 'Deudas por colaborador':
                $respuesta = $this->reporteDeudasColaborador($request);
                break;

            case 'Historial de deudas por colaborador':
                $respuesta = $this->reporteHistorialDeudasColaborador($request);
                break;
            default:
                $respuesta = "Error ";
                break;
        }


        return JsonResource::collection($respuesta);
    }

    public function reporteTotalDeudasPendiente($request)
    {
        ## aplica ambos filtros
        if (!is_null($request->desde) && !is_null($request->hasta)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->select('pago.id', 'pago.descripcion', DB::raw("COUNT(pago.id) as cuentas"), DB::raw("SUM(pago.monto) as total"), 'pago.fecha_fin')
                ->where('detalle_pagos.estado', 0)
                ->where('pago.fecha_inicio', '>', $request->desde)
                ->where('pago.fecha_fin', '<', $request->hasta)
                ->groupBy('id_pago')
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } elseif (!is_null($request->desde)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->select('pago.id', 'pago.descripcion', DB::raw("COUNT(pago.id) as cuentas"), DB::raw("SUM(pago.monto) as total"), 'pago.fecha_fin')
                ->where('detalle_pagos.estado', 0)
                ->where('pago.fecha_inicio', '>', $request->desde)
                ->groupBy('id_pago')
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } elseif (!is_null($request->hasta)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->select('pago.id', 'pago.descripcion', DB::raw("COUNT(pago.id) as cuentas"), DB::raw("SUM(pago.monto) as total"), 'pago.fecha_fin')
                ->where('detalle_pagos.estado', 0)
                ->where('pago.fecha_fin', '<', $request->hasta)
                ->groupBy('id_pago')
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } else {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->select('pago.id', 'pago.descripcion', DB::raw("COUNT(pago.id) as cuentas"), DB::raw("SUM(pago.monto) as total"), 'pago.fecha_fin')
                ->where('detalle_pagos.estado', 0)
                ->groupBy('id_pago')
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        }
    }



    public function reporteDeudasColaborador($request)
    {

        ## aplica ambos filtros
        if (!is_null($request->desde) && !is_null($request->hasta)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'colaborador.nombre', 'colaborador.apellido', 'pago.descripcion', 'pago.fecha_fin', 'pago.monto')
                ->where('detalle_pagos.estado', 0)
                ->where('colaborador.id', $request->colaborador)
                ->where('pago.fecha_inicio', '>', $request->desde)
                ->where('pago.fecha_fin', '<', $request->hasta)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } elseif (!is_null($request->desde)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'colaborador.nombre', 'colaborador.apellido', 'pago.descripcion', 'pago.fecha_fin', 'pago.monto')
                ->where('detalle_pagos.estado', 0)
                ->where('colaborador.id', $request->colaborador)
                ->where('pago.fecha_inicio', '>', $request->desde)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } elseif (!is_null($request->hasta)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'colaborador.nombre', 'colaborador.apellido', 'pago.descripcion', 'pago.fecha_fin', 'pago.monto')
                ->where('detalle_pagos.estado', 0)
                ->where('colaborador.id', $request->colaborador)
                ->where('pago.fecha_fin', '<', $request->hasta)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } else {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'colaborador.nombre', 'colaborador.apellido', 'pago.descripcion', 'pago.fecha_fin', 'pago.monto')
                ->where('detalle_pagos.estado', 0)
                ->where('colaborador.id', $request->colaborador)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        }
    }

    public function reporteHistorialDeudasColaborador($request)
    {
        if (!is_null($request->desde) && !is_null($request->hasta)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'pago.descripcion', 'detalle_pagos.estado', 'pago.fecha_fin', 'pago.monto')
                ->where('colaborador.id', $request->colaborador)
                ->where('pago.fecha_inicio', '>', $request->desde)
                ->where('pago.fecha_fin', '<', $request->hasta)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } elseif (!is_null($request->desde)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'pago.descripcion', 'detalle_pagos.estado', 'pago.fecha_fin', 'pago.monto')
                ->where('colaborador.id', $request->colaborador)
                ->where('pago.fecha_inicio', '>', $request->desde)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } elseif (!is_null($request->hasta)) {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'pago.descripcion', 'detalle_pagos.estado', 'pago.fecha_fin', 'pago.monto')
                ->where('colaborador.id', $request->colaborador)
                ->where('pago.fecha_fin', '<', $request->hasta)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        } else {
            return DetallePago::join('pago', 'pago.id', '=', 'detalle_pagos.id_pago')
                ->join('colaborador', 'colaborador.id', '=', 'detalle_pagos.id_colaborador')
                ->select('pago.id', 'pago.descripcion', 'detalle_pagos.estado', 'pago.fecha_fin', 'pago.monto')
                ->where('colaborador.id', $request->colaborador)
                ->orderBy('pago.fecha_fin', 'asc')
                ->get();
        }
    }
}
