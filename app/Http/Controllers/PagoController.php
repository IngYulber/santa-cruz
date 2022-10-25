<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Pago;
use App\Http\Requests\Pago\CreateRequest;
use App\Models\DetallePago;
use App\Models\User;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos = Pago::all();

        return JsonResource::collection($pagos);
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

        $users = User::all();

        foreach ($users as $user) {
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
        $detalle = DetallePago::join('users', 'users.id', '=', 'id_colaborador')
                                ->join('pago', 'pago.id', '=', 'id_pago')
                                ->where('detalle_pagos.id_pago', $id)
                                ->select('detalle_pagos.id','users.nombre','users.apellido','pago.monto','detalle_pagos.estado','detalle_pagos.updated_at')
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
