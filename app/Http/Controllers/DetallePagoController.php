<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallePagoController extends Controller
{
    public function update($id)
    {
        $detail = DetallePago::where('id', $id)->get()->first();
        try {
            DB::beginTransaction();

            $detail->estado = True;

            if ($detail->save()) {
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
