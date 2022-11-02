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
            'nombre' => 'Ricardo',
            'apellido' => 'Huamanrimachi Espinoza',
            'dni' => '07991231',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Roger Rogelio',
            'apellido' => 'Alacuti De la cruz',
            'dni' => '45075793',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Jose',
            'apellido' => 'Mundo Unocc',
            'dni' => '16176861',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Jesus',
            'apellido' => 'Agüero Vega',
            'dni' => '04041062',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Victor',
            'apellido' => 'Chancavilca Matos',
            'dni' => '10597686',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Francisco',
            'apellido' => 'Gomez Solano',
            'dni' => '23714606',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Valentin',
            'apellido' => 'Romero Borrena',
            'dni' => '23672319',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Andres Avelino',
            'apellido' => 'Peña Laban',
            'dni' => '16177198',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Delson Angel',
            'apellido' => 'De la cruz Mesa',
            'dni' => '80029848',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Fabian',
            'apellido' => 'Abregu Aguilar',
            'dni' => '46394040',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Oswaldo',
            'apellido' => 'Sinche Flores',
            'dni' => '16177276',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Leoncio',
            'apellido' => 'Cuadros Alarcon',
            'dni' => '16176864',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Valentin',
            'apellido' => 'Quispe Barrientos',
            'dni' => '09844008',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Raul',
            'apellido' => 'Sedano Lazaro',
            'dni' => '40180512',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Humberto',
            'apellido' => 'Arteaga Herrera',
            'dni' => '41156011',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Telio',
            'apellido' => 'Veramendi Hurtado',
            'dni' => '20740677',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Rolando',
            'apellido' => 'Gala Sedano',
            'dni' => '44422542',
        ]);

        DB::table('colaborador')->insert([
            'nombre' => 'Manuel Charlis',
            'apellido' => 'Ramos Gomez',
            'dni' => '43598455',
        ]);

    }
}
