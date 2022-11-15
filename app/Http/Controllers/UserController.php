<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UpdatePassword;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $id = auth()->user()->id;
        $user = User::where('id', $id)->first();
        return ($user);
    }

    public function create()
    {
        return view('content.perfil');
    }


    public function store(CreateRequest $request)
    {
        $user = User::create($request->validated());
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
        $user = User::where('id', auth()->user()->id)->get()->first();
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

    public function updatePassword(UpdatePassword $request){
        $contra = $request->password;
        $id = auth()->user()->id;

        $user = User::where('id', $id)->get()->first();
        $user->password = $contra;
        $user->save();

    }

    public function status(Request $request)
    {
        $user = User::where('id', $request->id)->get()->first();
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

    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        return view('login');
    }
}
