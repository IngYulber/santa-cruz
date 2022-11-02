<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Http\Requests\Colaborador\CreateRequest;
use App\Http\Requests\Colaborador\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ColaboradorController extends Controller
{
    public function index()
    {
        $colaboradores = Colaborador::all();
        return JsonResource::collection($colaboradores);
    }

    public function create()
    {
        return view('content.colaboradores');
    }


    public function store(CreateRequest $request)
    {
        $user = Colaborador::create($request->validated());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(UpdateRequest $request)
    {
        $user = Colaborador::where('id', $request->id)->get()->first();
        try {
            DB::beginTransaction();

            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->dni = $request->dni;

            if ($user->save()) {
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

    public function status(Request $request)
    {
        $user = Colaborador::where('id', $request->id)->get()->first();
        try {
            DB::beginTransaction();

            $user->estado = $request->estado;

            if ($user->save()) {
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
}
