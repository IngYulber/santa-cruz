<?php

namespace App\Http\Controllers;

use App\Models\Sancion;
use App\Http\Requests\Sancion\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class SancionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sanciones = Sancion::join('users', 'users.id','=','sancion.id_usuario')
                            ->select('sancion.id','sancion.motivo','users.nombre','users.apellido','sancion.created_at','sancion.dias_sancion','sancion.estado')
                            ->get();

        return JsonResource::collection($sanciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.sanciones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $reunion = Sancion::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $sancion = Sancion::where('id', $request->get('id'))->get()->first();
        try {
            DB::beginTransaction();

            $sancion->motivo = $request->motivo;
            $sancion->dias_sancion = $request->dias_sancion;
            $sancion->id_usuario  = $request->id_usuario ;

            if ($sancion->save()) {
                $response['status'] = 'ok';
            } else {
                $response['status']  = 'error';
            }
            echo json_encode($response);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
