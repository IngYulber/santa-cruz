<?php

namespace Database\Seeders;

use App\Models\Colaborador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colaborador')->insert([
            'nombre' => 'Ejemplo',
            'apellido' => 'Prueba',
            'dni' => '12345678',
        ]);

    }
}
