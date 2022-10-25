<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Reunion;
use App\Models\User;
use App\Http\Requests\Reunion\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reuniones = Reunion::all();
        return JsonResource::collection($reuniones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.reuniones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $reunion = Reunion::create($request->validated());

        $users = User::all();

        foreach ($users as $user) {
            $detail = new Asistencia();
            $detail->id_usuario  = $user->id;
            $detail->id_reunion  = $reunion->id;
            $detail->estado = 'falto';
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
        return view('content.reuniones_lista')->with('id',$id);
    }

    public function showDetail($id)
    {
        $detalle = Asistencia::join('users', 'users.id', '=', 'id_usuario')
                                ->join('reunion', 'reunion.id', '=', 'id_reunion')
                                ->where('asistencia.id_reunion', $id)
                                ->select('asistencia.id','asistencia.estado','users.nombre','users.apellido','reunion.created_at')
                                ->get();
        return JsonResource::collection($detalle);
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
        $reunion = Reunion::where('id', $request->get('id'))->get()->first();
        try {
            DB::beginTransaction();

            $reunion->description = $request->description;
            $reunion->fecha_programada = $request->fecha_programada;
            $reunion->asuntos = $request->asuntos;

            if ($reunion->save()) {
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
